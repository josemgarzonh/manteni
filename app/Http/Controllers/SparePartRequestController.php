<?php

namespace App\Http\Controllers;

use App\Models\SparePartRequest;
use Illuminate\Http\Request;

class SparePartRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = SparePartRequest::with(['maintenanceReport', 'user', 'asset'])->latest()->get();
        return view('inventory.spare-parts.index', compact('requests'));
    }

    // Aquí se podrían agregar métodos para update (cambiar estado), etc.
}

