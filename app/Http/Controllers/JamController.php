<?php

namespace App\Http\Controllers;

use App\Models\Jam; // Import model Jam
use Illuminate\Http\Request;
use App\Http\Requests\StorejamRequest;
use App\Http\Requests\UpdatejamRequest;
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
        //create new ruangan
        $jam = Jam::create([
            'jam' => $request->jam,
            'waktu' => $request->waktu,
        ]);

        return response()->json([
            'success' => 'Jam created successfully',
            'redirect' => route('jam'),
        ]);
    }

    public function show($id)
    {
        $jam = Jam::findOrFail($id);
        return response()->json($jam);
    }
    
    public function edit($id)
    {
        $jam = Jam::findOrFail($id);
        return response()->json($jam);
    }
    

    public function update(Request $request, $id)
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
    }

    public function delete($id)
    {
        $jam = Jam::find($id);
        $jam->delete();
        return response()->json([
            'success' => 'Hour deleted successfully',
            'redirect' => route('jam'),
        ]);
    }
}
