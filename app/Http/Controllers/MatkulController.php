<?php
namespace App\Http\Controllers;

use App\Models\Matkul;
use Illuminate\Http\Request;

class MatkulController extends Controller
{
    public function index()
    {
        $matkuls = Matkul::all();
        return view('admin.matkul.index', compact('matkuls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_matkul' => 'required',
            'nama_matkul' => 'required  ',
            'sks' => 'required'
        ]);

        Matkul::create($request->all());

        return response()->json([
            'success' => 'Mata Kuliah created successfully',
            'redirect' => route('matkul'),
        ]);
    }

    public function edit($id)
    {
        $matkul = Matkul::find($id);
        return response()->json($matkul);
    }

    public function update(Request $request, $id)
    {
        $matkul = Matkul::find($id);
        $request->validate([
            'kode_matkul' => 'required',
            'nama_matkul' => 'required',
            'sks' => 'required'
        ]);


        $matkul->update($request->all());

        return response()->json([
            'success' => 'Mata Kuliah updated successfully',
        ]);
    }

    public function destroy($id)
    {
        Matkul::destroy($id);

        return response()->json([
            'success' => 'Mata Kuliah deleted successfully',
        ]);
    }
}
