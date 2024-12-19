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
        $data =  ['data'=>DB::table('tracks')->select('tracks.*', 'users.name as performer_name')->join('users', 'tracks.performer_id', '=', 'users.id')->latest()->get(),
    'performers' => User::where('role', 'performer')->get(), 'count' => DB::table('tracks')->select('tracks.*', 'users.name as performer_name')->join('users', 'tracks.performer_id', '=', 'users.id')->latest()->get()->count()];
        return view('index', $data);
    }
    public function sfs (Request $request) {
        $data =  DB::table('tracks')->select('tracks.*', 'users.name as performer_name')->join('users', 'tracks.performer_id', '=', 'users.id');
        if ($request->search != null && $request->search != '') {
           $data = $data->where('tracks.name', 'LIKE', '%'.$request->search.'%');
        }
        if ($request->filter != null && $request->filter != '') {
            $data = $data->where('tracks.performer_id', '=', $request->filter);
        }
        if ($request->sort != null && $request->sort != '') {
            $data = $data->orderBy('created_at', $request->sort);
        }
        $data = $data->latest()->get();
        $data = ['data'=>$data, 'performers' => User::where('role', 'performer')->get(), 'count'=> $data->count()];
        return view('index', $data);
    }
    public function show_login () {
        
        return view('login');
    }
    public function show_reg () {
        return view('reg');
    }


    public function reg (Request $request) {
        // var_dump($request->role);
        // dd($request->all());
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
        'role'=>$request->role,]);

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
                return redirect()->route('/');
            }
            else {
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

    public function show_lk () {
        $data =  ['data'=>User::where('id',  Auth::id())->get()];
        return view('lk', $data);
    }

    public function lk (Request $request) {
        $user = User::where('id',  Auth::id())->first();
        $email_db = $user->email;
            if ($email_db == $request->email) {
                $validator = Validator::make($request->all(), [
                    "name"=>["required", "max:30"],
                    "email"=>["required", "email"],
                    "password"=>["required", "min:8"],
                    "password_old"=>["required"],
                ],
                $messages = [
                    'name.required' => 'Не введено имя',
                    'name.max' => 'Максимальная длина имени - 30 символов',
                    'email.required' => 'Не введена электронная почта',
                    'password.required' => 'Не введен пароль',
                    'password_old.required' => 'Не введен старый пароль',
                    'email.email' => 'Неверный формат почты',
                    'email.unique' => 'Пользователь с такой почтой уже есть',
                    'password.min' => 'Пароль должен быть не менее 8 символов',
                ]
            );
            }
            else {
                $validator = Validator::make($request->all(), [
                    "name"=>["required", "max:30"],
                    "email"=>["required", "email", "unique:users"],
                    "password"=>["required", "min:8"],
                    "password_old"=>["required"],
                ],
                $messages = [
                    'name.required' => 'Не введено имя',
                    'name.max' => 'Максимальная длина имени - 30 символов',
                    'email.required' => 'Не введена электронная почта',
                    'password.required' => 'Не введен пароль',
                    'password_old.required' => 'Не введен старый пароль',
                    'email.email' => 'Неверный формат почты',
                    'password.min' => 'Пароль должен быть не менее 8 символов',
                ]
            );
            }
    if ($validator->fails()) {
        return redirect()->route('lk')->withErrors($validator);
    }
    else {
        $user = User::where('id',  Auth::id())->first();
        $pass = $user->password;
        if (Hash::check($request->password_old, $pass)) {
            $user = User::where('id', Auth::id())->update(['name'=>$request->name,
                                                        'email'=>$request->email,
                                                        'password'=>Hash::make($request->password)]);
            return redirect()->route('lk')->withErrors(['message' => 'Данные успешно обновлены']);
        }
        else {
            return redirect()->route('lk')->withErrors(['password_old' => 'Неверный старый пароль']);
        }
        
    }
        
    }
}
