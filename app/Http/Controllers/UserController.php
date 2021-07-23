<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function register(RegisterUserRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $validatedData = $request->validated();
        
        $validatedData['password'] = Hash::make($validatedData['password']);
        
        $user = User::create($validatedData);
        
        Auth::login($user);

//        event(new Registered($user));
        
        return response(['name' => auth()->user()->name], 200);
    }
    
    
    public function login(Request $request)
    {
        $validatedData = $request->validate(['email' => 'required|email', 'password' => 'required|min:6',]);
        
        if (Auth::attempt(
            $validatedData,
            $request->validate(['remember' => 'string|max:5']) === 'true'
        )
        ) {
            $request->session()->regenerate();
            
            return response(['name'  => auth()->user()->name,
                             'image' => auth()->user()->image ?? null,
                             'role'  => auth()->user()->role,],
                            200);
        }
        
        return response('Incorrect email or password', 401)->header('Content-Type', 'text/plain');
    }
    
    
    public function logout(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        Auth::logout();
        
        $request->session()->invalidate();
        
        $request->session()->regenerateToken();
        
        return response('success', 200);
    }
    
    
    public function show(): \Illuminate\Http\Response|array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        if (auth()->check()) {
            return ['name'       => auth()->user()->name,
                    'role'       => auth()->user()->role,
                    'email'      => auth()->user()->email,
                    'created_at' => auth()->user()->created_at,];
        }
        
        return response('guest', 200);
    }
    
    
    public function update(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|min:3|max:50']);
        
        User::where('id', auth()->user()->id)->update(['name' => $validated['name']]);
        
        return User::find(auth()->user()->id)->toArray();
    }
    
    
    public function index(): array
    {
        return User::All()->toArray();
    }
    
    
    public function updateRole(Request $request)
    {
        $validated = $request->validate([
                                            'id'   => 'required|numeric',
                                            'role' => 'required|numeric']);
        
        User::where('id', $validated['id'])->update(['role' => $validated['role']]);
        
        return User::find($validated['id'])->toArray();
    }
    
}
