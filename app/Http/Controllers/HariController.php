<?php

namespace App\Http\Controllers;

use App\Models\hari;
use Illuminate\Http\Request;

class HariController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $haris = hari::all();
        return view('admin.waktu.hari ', compact('haris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
        ]);
        //create new hari
        $hari = hari::create([
            'hari' => $request->hari,
        ]);
        return response()->json([
            'success' => 'Hari created successfully',
            'redirect' => route('hari'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(hari $hari)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(hari $hari)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request, hari $hari)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(hari $hari)
    {
        //
    }
}
