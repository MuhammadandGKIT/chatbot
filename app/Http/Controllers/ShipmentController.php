<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;

class ShipmentController extends Controller
{
    public function index()
    {
        return response()->json(Shipment::all(), 200);
    }

    public function show($id)
    {
        $shipment = Shipment::find($id);

        if (!$shipment) {
            return response()->json(['message' => 'Shipment not found'], 404);
        }

        return response()->json($shipment, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_invoice' => 'required|unique:shipments',
            'recipient_name' => 'required',
            'shipping_address' => 'required',
            'total_payment' => 'required|numeric',
        ]);

        $shipment = Shipment::create($request->all());

        return response()->json($shipment, 201);
    }

    public function update(Request $request, $id)
    {
        $shipment = Shipment::find($id);

        if (!$shipment) {
            return response()->json(['message' => 'Shipment not found'], 404);
        }

        $shipment->update($request->all());

        return response()->json($shipment, 200);
    }

    public function destroy($id)
    {
        $shipment = Shipment::find($id);

        if (!$shipment) {
            return response()->json(['message' => 'Shipment not found'], 404);
        }

        $shipment->delete();

        return response()->json(['message' => 'Shipment deleted'], 200);
    }
}
