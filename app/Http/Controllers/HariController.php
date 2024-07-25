<?php
namespace App\Http\Controllers;

use App\Models\Hari;
use Illuminate\Http\Request;

class HariController extends Controller
{
    public function index()
    {
        $haris = Hari::all();
        return view('admin.waktu.hari', compact('haris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
        ]);

        $hari = Hari::create([
            'hari' => $request->hari,
        ]);

        return response()->json([
            'success' => 'Hari created successfully',
        ]);
    }

    public function edit($id)
    {
        $hari = Hari::findOrFail($id);
        return response()->json($hari);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hari' => 'required',
        ]);

        $hari = Hari::findOrFail($id);
        $hari->update([
            'hari' => $request->hari,
        ]);

        return response()->json([
            'success' => 'Hari updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $hari = Hari::findOrFail($id);
        $hari->delete();

        return response()->json([
            'success' => 'Hari deleted successfully',
        ]);
    }
}
