<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QontakController extends Controller
{




    public function receive(Request $request)
{
    $webhookEvent = $request->input('webhook_event'); 
    $dataEvent    = $request->input('data_event');    

    // Normalisasi data dari webhook
    $normalized = [
        'message' => [
            'id'         => $request->input('id'),
            'text'       => $request->input('text'),
            'sender_id'  => $request->input('sender_id'),
            'created_at' => $request->input('created_at'),
        ],
        'room' => [
            'id'              => $request->input('room.id'),
            'account_uniq_id' => $request->input('room.account_uniq_id'),
            'organization_id' => $request->input('room.organization_id'),
            'is_unresponded'  => $request->input('room.is_unresponded'),
        ],
        'sender' => [
            'name'             => $request->input('sender.name'),
            'participant_type' => $request->input('sender.participant_type'),
        ],
        'meta' => [
            'channel'    => $request->input('room.channel'),
            'data_event' => $dataEvent,
        ],
    ];

    // Logging standar Laravel
    Log::info("🔥 Normalized Webhook", $normalized);

    // ✅ Fallback manual logging
    $logPath = storage_path('logs/webhook_debug.log');
    file_put_contents(
        $logPath,
        "[" . now() . "] Normalized Data: " . json_encode($normalized, JSON_PRETTY_PRINT) . PHP_EOL,
        FILE_APPEND
    );

    if ($webhookEvent === 'message_interaction' && $dataEvent === 'receive_message_from_customer') {
        try {
            // 1️⃣ Kirim pertanyaan ke Flowise
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post("https://cloud.flowiseai.com/api/v1/prediction/cca885c8-fbea-49e3-94ce-6f8f14137fb8", [
                'question' => $normalized['message']['text'],
            ]);

            $flowiseData = $response->json();
            Log::info("🤖 Flowise response:", $flowiseData);

            // ✅ Fallback log Flowise
            file_put_contents(
                $logPath,
                "[" . now() . "] Flowise Response: " . json_encode($flowiseData, JSON_PRETTY_PRINT) . PHP_EOL,
                FILE_APPEND
            );

            // Ambil jawaban atau fallback
            $answer = $flowiseData['text'] ?? "Maaf, saya tidak bisa memproses permintaan kamu sekarang 🙏";

            // 2️⃣ Kirim balik ke Qontak
            $qontakResponse = Http::withHeaders([
                'Authorization' => 'Bearer JCXvkjGiACxo4DGiHg8zMpBc3-WPP_eCVSVl9DtTl4Q',
                'Content-Type'  => 'application/json',
            ])->post('https://service-chat.qontak.com/api/open/v1/messages/whatsapp', [
                'room_id' => 'fad6f866-fef2-42ff-8f4b-9bca4d81b172392923',
                'type'    => 'text',
                'text'    => $answer,
            ]);

            Log::info("📤 Qontak response:", $qontakResponse->json());

            // ✅ Fallback log Qontak
            file_put_contents(
                $logPath,
                "[" . now() . "] Qontak Response: " . json_encode($qontakResponse->json(), JSON_PRETTY_PRINT) . PHP_EOL,
                FILE_APPEND
            );

            return response()->json([
                'status'   => 'ok',
                'received' => $normalized,
                'flowise'  => $flowiseData,
                'reply'    => $answer
            ], 200);

        } catch (\Exception $e) {
            Log::error("❌ Error di Flowise/Qontak: " . $e->getMessage());

            // ✅ Fallback log error
            file_put_contents(
                $logPath,
                "[" . now() . "] ERROR: " . $e->getMessage() . PHP_EOL,
                FILE_APPEND
            );

            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    return response()->json([
        'status' => 'ok',
        'data'   => $normalized
    ], 200);
}


   
    
    
    
    
}
