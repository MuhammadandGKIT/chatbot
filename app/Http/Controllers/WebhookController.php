<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        log::info($request->all());
        $raw = $request->getContent();
        $parsed = $request->all();
        $headers = $request->headers->all();
    
        Log::info('Webhook headers', $headers);
        Log::info('Webhook raw', ['raw' => $raw]);
        Log::info('Webhook parsed', ['parsed' => $parsed]);
    
        // ✅ Validasi webhook dari Qontak
        if ($request->has('verify_info')) {
            Log::info('Webhook verification received', [
                'verify_info' => $request->input('verify_info')
            ]);
    
            return response()->json([
                'status' => 'verified',
                'verify_info' => $request->input('verify_info')
            ], 200);
        }
    
        // ✅ Proses data webhook normal
        Log::info('Webhook event received', $parsed);
    
        return response()->json([
            'status' => 'ok',
            'message' => 'Webhook diterima'
        ], 200);
    }
    
}
