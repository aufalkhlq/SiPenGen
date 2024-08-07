<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function profile()
    {
        $user = Auth::user();
        return view('auth.profile', ['user' => $user]);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed|different:current_password',
        ]);

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return response()->json([
                'error' => 'Password lama tidak cocok.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return response()->json([
            'success' => 'Password berhasil diperbarui',
            'redirect' => route('profile'),
        ], Response::HTTP_OK);
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'identifier' => 'required',
            'password' => 'required'
        ]);

        $identifier = $validate['identifier'];
        $password = $validate['password'];

        // Login as user using email
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            if (Auth::guard('web')->attempt(['email' => $identifier, 'password' => $password])) {
                $user = Auth::guard('web')->user();
                return $this->redirectUser($user);
            }
        } else {
            // Login as dosen using NIP first
            $dosen = Dosen::where('nip', $identifier)->first();
            if ($dosen && Hash::check($password, $dosen->password)) {
                Auth::guard('dosen')->login($dosen);
                return $this->redirectUser($dosen);
            }

            // If not dosen, then check mahasiswa using NIM
            $mahasiswa = Mahasiswa::where('nim', $identifier)->first();
            if ($mahasiswa && Hash::check($password, $mahasiswa->password)) {
                Auth::guard('mahasiswa')->login($mahasiswa);
                return $this->redirectUser($mahasiswa);
            }
        }

        return response()->json([
            'error' => 'Invalid Email/NIM/NIP or Password details',
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function redirectUser($user)
    {
        if ($user instanceof User) {
            if ($user->role == 'admin') {
                return response()->json([
                    'success' => 'Welcome to the admin dashboard',
                    'redirect' => route('dashboard'),
                ]);
            }
        } elseif ($user instanceof Mahasiswa) {
            return response()->json([
                'success' => 'Welcome to the mahasiswa dashboard',
                'redirect' => route('mahasiswa.dashboard'),
            ]);
        } elseif ($user instanceof Dosen) {
            return response()->json([
                'success' => 'Welcome to the dosen dashboard',
                'redirect' => route('dosen.dashboard'),
            ]);
        }

        return response()->json([
            'error' => 'Unauthorized',
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function logout()
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        } elseif (Auth::guard('mahasiswa')->check()) {
            Auth::guard('mahasiswa')->logout();
        } elseif (Auth::guard('dosen')->check()) {
            Auth::guard('dosen')->logout();
        }
        return redirect()->route('login');
    }
}
