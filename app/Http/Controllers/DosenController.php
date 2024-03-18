<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dosens = Dosen::all();
        return view('dosen.index',compact('dosens'));
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
            'nama_dosen' => 'required',
            'nip' => 'required|numeric',
            'prodi' => 'required',
        ]);
        //create new dosen
        $dosen = Dosen::create([
            'nama_dosen' => $request->nama_dosen,
            'nip' => $request->nip,
            'prodi' => $request->prodi,
        ]);
        return response()->json([
            'success' => 'Dosen created successfully',
            'redirect' => route('dosen'),
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Dosen $dosen)
    {
        $dosen = Dosen::find($dosen);
        return response()->json($dosen);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dosen $dosen)
    {
        return response()->json($dosen);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $dosen = Dosen::find($id);

        $request->validate([
            'edit-nama_dosen' => 'required',
            'edit-nip' => 'required|numeric',
            'edit-prodi' => 'required',
        ]);

        $dosen->nama_dosen = $request->input('edit-nama_dosen');
        $dosen->nip = $request->input('edit-nip');
        $dosen->prodi = $request->input('edit-prodi');

        $dosen->save();

        if ($dosen) {
            return response()->json([
                'success' => 'dosen edited successfully',
                'redirect' => route('dosen'),
            ]);
        } else {
            return response()->json([
                'error' => 'Failed to edit dosen. Please try again.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $dosen = Dosen::find($id);
        $dosen->delete();
        return response()->json([
            'success' => 'Dosen deleted successfully',
            'redirect' => route('dosen'),
        ]);
    }
}
