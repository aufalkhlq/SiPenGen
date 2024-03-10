<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt($validate)) {
            return response()->json([
                'success' => 'Welcome to the dashboard',
                'redirect' => route('dashboard'),
            ]);
        } else {
            return response()->json([
                'error' => 'Invalid Email or Password details',
            ], Response::HTTP_UNPROCESSABLE_ENTITY); // Return HTTP status code 422 for unprocessable entity
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
