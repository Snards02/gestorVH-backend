<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FuelLog;

class FuelLogController extends Controller
{
    public function index($vehicleId)
    {
        return FuelLog::where('vehicle_id', $vehicleId)->get();
    }

    public function store(Request $request, $vehicleId)
    {
        $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'receipt' => 'required|image',
        ]);

        $path = $request->file('receipt')->store('receipts', 'public');

        $log = FuelLog::create([
            'date' => $request->date,
            'amount' => $request->amount,
            'receipt_path' => $path,
            'vehicle_id' => $vehicleId
        ]);

        return response()->json($log, 201);
    }
}
