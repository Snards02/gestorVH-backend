<?php
namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        return Vehicle::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'plate' => 'required|string|unique:vehicles,plate',
            'type' => 'required|string',
        ]);

        $vehicle = Vehicle::create($request->all());

        return response()->json($vehicle, 201);
    }

    public function show($id)
    {
        $vehicle = Vehicle::with(['documents', 'fuelLogs'])->findOrFail($id);
        return response()->json($vehicle);
    }
}
