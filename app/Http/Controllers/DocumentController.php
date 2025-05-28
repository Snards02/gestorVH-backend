<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index($vehicleId)
    {
        $documents = Document::where('vehicle_id', $vehicleId)->get();
        return response()->json($documents);
    }

    public function store(Request $request, $vehicleId)
    {
        $request->validate([
            'type' => 'required|string',
            'expiration_date' => 'required|date',
            'file' => 'required|file|mimes:jpeg,png,pdf'
        ]);

        // Guardar archivo
        $path = $request->file('file')->store('documents', 'public');

        $document = Document::create([
            'type' => $request->type,
            'expiration_date' => $request->expiration_date,
            'file_path' => $path,
            'vehicle_id' => $vehicleId
        ]);

        return response()->json($document, 201);
    }
}

