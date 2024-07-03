<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function dosen()
    {
        $users = User::all();
        return view('user.dosen', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,dosen,mahasiswa'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        $user->setRememberToken(Str::random(50));
        $user->save();

        return response()->json([
            'success' => 'User created successfully',
            'redirect' => route('user'),
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([
            'edit-name' => 'required|max:255',
            'edit-email' => 'required|email|unique:users,email,' . $id,
            'edit-role' => 'required|in:admin,dosen,mahasiswa'
        ]);

        $user->name = $request->input('edit-name');
        $user->email = $request->input('edit-email');
        $user->role = $request->input('edit-role');

        if ($request->input('edit-password')) {
            $request->validate(['edit-password' => 'required|min:8']);
            $user->password = bcrypt($request->input('edit-password'));
        }

        $user->save();

        return response()->json([
            'success' => 'User updated successfully',
            'redirect' => route('user'),
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);

        // Return the user data as JSON
        return response()->json($user);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, $id)
    // {
    //     $user = User::find($id);

    //     if (!$user) {
    //         return response()->json(['error' => 'User not found'], 404);
    //     }

    //     $request->validate([
    //         'edit-name' => 'required|max:255',
    //         'edit-email' => 'required|email|unique:users,email,' . $id,
    //     ]);

    //     $user->name = $request->input('edit-name');
    //     $user->email = $request->input('edit-email');

    //     // Only update the password if a new one is provided
    //     if ($request->input('edit-password')) {
    //         $request->validate([
    //             'edit-password' => 'required|min:8',
    //         ]);
    //         $user->password = bcrypt($request->input('edit-password'));
    //     } else{

    //     }

    //     $user->save();

    //     if ($user) {
    //         return response()->json([
    //             'success' => 'User edited successfully',
    //             'redirect' => route('user'),
    //         ]);
    //     }
    //     else {
    //         return response()->json([
    //             'error' => 'Failed to edit user. Please try again.',
    //         ], Response::HTTP_UNPROCESSABLE_ENTITY);
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['success' => 'User deleted successfully']);
    }
}
