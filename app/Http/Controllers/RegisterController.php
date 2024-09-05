<?php

namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegistrationForm()
        {
            return view('auth.register');
        }

        public function register(Request $request)
        {
            $this->validator($request->all())->validate();

            $user = $this->create($request->all());

            auth()->login($user);

            return redirect()->route('/dashboard');
        }

        protected function validator(array $data)
        {
            return Validator::make($data, [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => [
                        'required',
                        'string',
                        'min:8',
                        'regex:/[A-Z]/',
                        'regex:/[0-9]/',
                        'regex:/[@$!%*#?&]/',
                        'confirmed'
                    ],
                ], [
                    'password.regex' => 'The password must contain at least one uppercase letter, one digit, and one special character.',
                ]);
        }

        protected function create(array $data)
        {
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        }
}
