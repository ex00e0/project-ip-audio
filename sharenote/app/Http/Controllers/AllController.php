<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Track;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

class AllController extends Controller
{
    public function index () {
        $data =  ['data'=>Track::where('id', 1)->latest()->get()];
        return view('index', $data);
    }
    public function show_login () {
        
        return view('login');
    }
    public function show_reg () {
        return view('reg');
    }


    public function reg (Request $request) {

        $validator = Validator::make($request->all(), [
            "name"=>["required", "max:30"],
            "email"=>["required", "email", "unique:users"],
            "password"=>["required", "min:8"],
        ],
        $messages = [
            'name.required' => 'Не введено имя',
            'name.max' => 'Максимальная длина имени - 30 символов',
            'email.required' => 'Не введена электронная почта',
            'password.required' => 'Не введен пароль',
            'email.email' => 'Неверный формат почты',
            'email.unique' => 'Пользователь с такой почтой уже есть',
            'password.min' => 'Пароль должен быть не менее 8 символов',
        ]
    );
    if ($validator->fails()) {
        return redirect()->route('reg')->withErrors($validator);
    }
    else {
        $user = User::create(['name'=>$request->name,
        'email'=>$request->email,
        'password'=>Hash::make($request->password),
        'role' => $request->role ]);

        Auth::login($user);
        return redirect()->route('/');
    }
        
    }

    public function login (Request $request) {


        $validator = Validator::make($request->all(), [
            "email"=>["required", "email"],
            "password"=>["required"],
        ],
        $messages = [
            'email.required' => 'Не введена электронная почта',
            'password.required' => 'Не введен пароль',
            'email.email' => 'Неверный формат почты',
        ]
    );
    if ($validator->fails()) {
        return redirect()->route('login')->withErrors($validator);
    }
    else {

        $user = User::where('email', $request->email)->exists();
        if ($user != false) {
        $user = User::where('email', $request->email)->first();
        $pass = $user->password;
        $id = $user->id;
        $role = $user->role;

        if (Hash::check($request->password, $pass)) {
            Auth::login(User::find($id));
            if ($role == 'listener' || $role == 'performer') {
                session_start();
                $_SESSION['role'] = 'performer';
                return redirect()->route('/');
            }
            else {
                session_start();
                $_SESSION['role'] = 'admin';
                return redirect()->route('admin');
            }
            
        } else {
            return redirect()->route('login')->withErrors(['password' => 'Неверный пароль']);
     }  
    }
    else {
        return redirect()->route('login')->withErrors(['email' => 'Такого пользователя нет']);
    }
}
    }

    public function exit() {
        Auth::logout();
        return redirect()->route('/');
    }
}
