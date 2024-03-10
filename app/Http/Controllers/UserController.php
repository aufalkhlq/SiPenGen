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
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

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
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->setRememberToken(Str::random(50));
        $user->save();

        if ($user) {
            return response()->json([
                'success' => 'User created successfully',
                'redirect' => route('user'),
            ]);
        } else {
            return response()->json([
                'error' => 'Failed to created user. Please try again.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

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
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $request->validate([
            'edit_name' => 'required|max:255',
            'edit_email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user->name = $request->input('edit_name');
        $user->email = $request->input('edit_email');

        // Only update the password if a new one is provided
        if ($request->input('edit_password')) {
            $request->validate([
                'edit_password' => 'required|min:8',
            ]);
            $user->password = bcrypt($request->input('edit_password'));
        }

        $user->save();

        if ($user) {
            return response()->json([
                'success' => 'User edited successfully',
                'redirect' => route('user'),
            ]);
        } else {
            return response()->json([
                'error' => 'Failed to edit user. Please try again.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

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
