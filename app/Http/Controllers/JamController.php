<?php

namespace App\Http\Controllers;

use App\Models\Jam;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JamController extends Controller
{
    public function index()
    {
        $jams = Jam::all();
        return view('admin.waktu.jam', compact('jams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jam' => 'required',
            'waktu' => 'required',
        ]);

        Jam::create($validated);
        return response()->json(['success' => 'Hour added successfully']);
    }

    public function edit(Jam $jam)
    {
        return response()->json($jam);
    }

    public function update(Request $request, Jam $jam)
    {
        $validated = $request->validate([
            'jam' => 'required',
            'waktu' => 'required',
        ]);

        $jam->update($validated);
        return response()->json(['success' => 'Hour updated successfully']);
    }


    public function delete(Jam $jam)
    {
        $jam->delete();
        return response()->json(['success' => 'Hour deleted successfully']);
    }
}
