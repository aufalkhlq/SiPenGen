<?php

namespace App\Http\Controllers;

use App\Models\hari;
use App\Http\Requests\StorehariRequest;
use App\Http\Requests\UpdatehariRequest;

class HariController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('waktu.hari');
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
    public function store(StorehariRequest $request)
    {
        //
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
    public function update(UpdatehariRequest $request, hari $hari)
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
