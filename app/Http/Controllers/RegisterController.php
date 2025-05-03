<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

// Import the Hash facade

class RegisterController extends Controller
{
    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email', // Ensure email is unique
            'password' => 'required|min:8',                    // Set your password minimum length as needed
        ]);

        // Hash the password before saving it
        $validated['password'] = Hash::make($validated['password']);

        // Create a new user
        User::create($validated);

        return redirect(route('home'));
    }
}
