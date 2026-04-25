<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
            'phone'    => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'role'     => 'user',
        ]);

        $token = auth('api')->login($user);

        return response()->json([
            'message' => 'Compte créé avec succès',
            'user'    => $user,
            'token'   => $token,
        ], 201);
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Email ou mot de passe incorrect'], 401);
        }

        return response()->json([
            'token' => $token,
            'user'  => auth('api')->user(),
        ]);
    }

    public function logout() {
        auth('api')->logout();
        return response()->json(['message' => 'Déconnecté avec succès']);
    }

    public function me() {
        return response()->json(auth('api')->user());
    }
}