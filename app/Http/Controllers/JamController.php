<?php

namespace App\Http\Controllers;

use App\Models\jam;
use App\Http\Requests\StorejamRequest;
use App\Http\Requests\UpdatejamRequest;

class JamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('waktu.jam');
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
    public function store(StorejamRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(jam $jam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(jam $jam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatejamRequest $request, jam $jam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(jam $jam)
    {
        //
    }
}
