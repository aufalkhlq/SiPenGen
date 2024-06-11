<?php

namespace App\Http\Controllers;

use App\Models\Jam; // Import model Jam
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JamController extends Controller
{
    public function index()
    {
        $jams = Jam::all();
        return view('waktu.jam', compact('jams'));
        // return view('waktu.jam');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'jam' => 'required',
            'waktu' => 'required',

        ]);

        //create new jam
        $jam = jam::create([

            'jam' => $request->jam,
            'waktu' => $request->waktu,
        ]);

    }


    /**
     * Display the specified resource.
     */
    public function show(jam $jam)
    {
        $jam = Jam::findOrFail($id);
        return response()->json($jam);
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(jam $jam)
    {
        $jam = Jam::findOrFail($id);
        return response()->json($jam);
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, jam $jam)
    {
        $jam = Jam::findOrFail($id);

        $request->validate([
            'edit-jam' => 'required',
            'edit-waktu' => 'required',
        ]);

        // Update data
        $jam->jam = $request->input('edit-jam');
        $jam->waktu = $request->input('edit-waktu');

        $jam->save();

        return response()->json([
            'success' => 'Jam edited successfully',
            'redirect' => route('jam'),
        ]);
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(jam $jam)
    {
        $jam = Jam::find($id);
        $jam->delete();
        return response()->json([
            'success' => 'Hour deleted successfully',
            'redirect' => route('jam'),
        ]);

    }
}
