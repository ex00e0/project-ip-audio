<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Liked_post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Post;
use App\Models\Track;
use App\Models\Save;
use App\Models\Message;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

class AllController extends Controller
{
    public function index ($page = null) {
    //     if (Auth::id() != null) {
    //         $count = DB::table('tracks')->select('tracks.*', 'users.name as performer_name', DB::raw('count(CASE WHEN saves.user_id = '. Auth::id() .' THEN 1 ELSE NULL END) as is_save'))->join('users', 'tracks.performer_id', '=', 'users.id')->join('saves', 'tracks.id', '=', 'saves.track_id','left outer')->groupBy('tracks.id')->latest()->get()->count();
    //         if ($count < 12) {
    //             $tracks = DB::table('tracks')->select('tracks.*', 'users.name as performer_name', DB::raw('count(CASE WHEN saves.user_id = '. Auth::id() .' THEN 1 ELSE NULL END) as is_save'))->join('users', 'tracks.performer_id', '=', 'users.id')->join('saves', 'tracks.id', '=', 'saves.track_id','left outer')->groupBy('tracks.id')->latest()->get();
    //         }
    //         else {
    //             // dd($page);
    //             if ($page == null) {
    //                 $tracks = DB::table('tracks')->select('tracks.*', 'users.name as performer_name', DB::raw('count(CASE WHEN saves.user_id = '. Auth::id() .' THEN 1 ELSE NULL END) as is_save'))->join('users', 'tracks.performer_id', '=', 'users.id')->join('saves', 'tracks.id', '=', 'saves.track_id','left outer')->groupBy('tracks.id')->latest()->take(12)->get();
    //             }
    //             else {
                    
    //                 $tracks = DB::table('tracks')->select('tracks.*', 'users.name as performer_name', DB::raw('count(CASE WHEN saves.user_id = '. Auth::id() .' THEN 1 ELSE NULL END) as is_save'))->join('users', 'tracks.performer_id', '=', 'users.id')->join('saves', 'tracks.id', '=', 'saves.track_id','left outer')->groupBy('tracks.id')->latest()->skip((intval($page)-1)*12)->take(12)->get();
    //                 // dd($tracks);
    //             }
    //         }
    //     }
    //     else {
    //         $count = DB::table('tracks')->select('tracks.*', 'users.name as performer_name')->join('users', 'tracks.performer_id', '=', 'users.id')->latest()->get()->count();
    //     if ($count < 12) {
    //         $tracks = DB::table('tracks')->select('tracks.*', 'users.name as performer_name')->join('users', 'tracks.performer_id', '=', 'users.id')->latest()->get();
    //     }
    //     else {
    //         // dd($page);
    //         if ($page == null) {
    //             $tracks = DB::table('tracks')->select('tracks.*', 'users.name as performer_name')->join('users', 'tracks.performer_id', '=', 'users.id')->latest()->take(12)->get();
    //         }
    //         else {
                
    //             $tracks = DB::table('tracks')->select('tracks.*', 'users.name as performer_name')->join('users', 'tracks.performer_id', '=', 'users.id')->latest()->skip((intval($page)-1)*12)->take(12)->get();
    //             // dd($tracks);
    //         }
    //     }
    //     }
    //     $data =  ['data'=>$tracks,
    // 'performers' => User::where('role', 'performer')->get(), 'count' => $count, 'page' => $page];
        $data = ['data' => Album::latest()->limit(10)->get()];
        return view('index', $data);
    }
    public function sfs (Request $request) {
        if (Auth::id() != null) {
            $data = DB::table('tracks')->select('tracks.*', 'users.name as performer_name', DB::raw('count(CASE WHEN saves.user_id = '. Auth::id() .' THEN 1 ELSE NULL END) as is_save'))->join('users', 'tracks.performer_id', '=', 'users.id')->join('saves', 'tracks.id', '=', 'saves.track_id','left outer');
        }
        else {
            $data =  DB::table('tracks')->select('tracks.*', 'users.name as performer_name')->join('users', 'tracks.performer_id', '=', 'users.id');
        }
        if ($request->search != null && $request->search != '') {
           $data = $data->where('tracks.name', 'LIKE', '%'.$request->search.'%');
        }
        if ($request->filter != null && $request->filter != '') {
            $data = $data->where('tracks.performer_id', '=', $request->filter);
        }
        if (Auth::id() != null) {
        $data = $data->groupBy('tracks.id');
    }
        if ($request->sort != null && $request->sort != '') {
            $data = $data->orderBy('created_at', $request->sort);
        }
        // dd($data);
        
        $count = $data->latest()->get()->count();
        
        // dd($data);
        if ($count <= 12) {
            $data = $data->latest()->get();
        }
        else {
            if ($request->page == null) {
                $data = $data->latest()->take(12)->get();
            }
            else {
                $data = $data->latest()->skip((intval($request->page)-1)*12)->take(12)->get();
                // dd($tracks);
            }
        }
        // dd($data);
        $data = ['data'=>$data, 'performers' => User::where('role', 'performer')->get(), 'count'=> $count, 'page'=> $request->page];
        return view('index', $data);
    }
    public function show_login () {
        
        return view('login');
    }
    public function show_reg () {
        return view('reg');
    }

    public function popular () {
        $tracks = DB::table('tracks')->select('tracks.*', 'users.name as performer_name')->join('users', 'tracks.performer_id', '=', 'users.id')->orderBy('count_l', 'DESC')->limit(10)->get();
        $albums = Album::orderBy('count_l', 'DESC')->limit(10)->get();
        $data = ['data' => $tracks, 'albums' => $albums];
        return view('popular', $data);
    }

    public function performers () {
        if (Auth::id() != null) {
            $posts = DB::table('posts')->select('posts.*', 'tracks.name', 'tracks.file', 'users.name as performer_name', 'users.img as performer_img', DB::raw('count(CASE WHEN saves.user_id = '. Auth::id() .' THEN 1 ELSE NULL END) as is_save'), DB::raw('count(CASE WHEN liked_posts.user_id = '. Auth::id() .' THEN 1 ELSE NULL END) as is_liked'))->join('tracks', 'tracks.id', '=', 'posts.track_id', 'left outer')->join('users', 'posts.performer_id', '=', 'users.id', 'left outer')->join('saves', 'tracks.id', '=', 'saves.track_id','left outer')->join('liked_posts', 'liked_posts.post_id', '=', 'posts.id', 'left outer')->groupBy('posts.id')->latest()->get();

        }
        else {
            $posts = DB::table('posts')->select('posts.*', 'tracks.name', 'tracks.file', 'users.name as performer_name', 'users.img as performer_img')->join('tracks', 'tracks.id', '=', 'posts.track_id', 'left outer')->join('users', 'posts.performer_id', '=', 'users.id', 'left outer')->latest()->get();

        }
        // $track = DB::table('tracks')->select('tracks.*', 'users.name as performer_name')->join('users', 'tracks.performer_id', '=', 'users.id')->orderBy('count_l', 'DESC')->limit(10)->get();
        $posts = ['posts' => $posts];
        return view('performers', $posts);
    }

    public function search_posts_text (Request $request) {
        if (Auth::id() != null) {
            $posts = DB::table('posts')->select('posts.*', 'tracks.name', 'tracks.file', 'users.name as performer_name', 'users.img as performer_img', DB::raw('count(CASE WHEN saves.user_id = '. Auth::id() .' THEN 1 ELSE NULL END) as is_save'), DB::raw('count(CASE WHEN liked_posts.user_id = '. Auth::id() .' THEN 1 ELSE NULL END) as is_liked'))->join('tracks', 'tracks.id', '=', 'posts.track_id', 'left outer')->join('users', 'posts.performer_id', '=', 'users.id', 'left outer')->join('saves', 'tracks.id', '=', 'saves.track_id','left outer')->join('liked_posts', 'liked_posts.post_id', '=', 'posts.id', 'left outer')->where('posts.text', 'LIKE', "%$request->text%")->groupBy('posts.id')->latest()->get();

        }
        else {
            $posts = DB::table('posts')->select('posts.*', 'tracks.name', 'tracks.file', 'users.name as performer_name', 'users.img as performer_img')->join('tracks', 'tracks.id', '=', 'posts.track_id', 'left outer')->join('users', 'posts.performer_id', '=', 'users.id', 'left outer')->where('posts.text', 'LIKE', "%$request->text%")->latest()->get();

        }
        $posts = ['posts' => $posts];
        return response()->json($posts);
    }

    public function like_post (Request $request) {
        $post = Post::where('id', $request->id)->get();
        $isset = Liked_post::where('user_id', Auth::id())->where('post_id', $request->id)->get()->count();
        if ($isset == 0) {
            $likes = $post[0]->likes + 1;
            Post::where('id', $request->id)->update(['likes' => $likes]);
            Liked_post::create(['user_id' => Auth::id(), 'post_id' => $request->id]);
            return response()->json($likes);
        }
        else {
            return response()->json('stop');
        }
        
    }

    public function dislike_post (Request $request) {
        $post = Post::where('id', $request->id)->get();
        $isset = Liked_post::where('user_id', Auth::id())->where('post_id', $request->id)->get()->count();
        if ($isset == 1) {
            $likes = $post[0]->likes - 1;
            Post::where('id', $request->id)->update(['likes' => $likes]);
            Liked_post::where('user_id', Auth::id())->where('post_id', $request->id)->delete();
            return response()->json($likes);
        }
        else {
            return response()->json('stop');
        }
        
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
                return redirect()->route('admin_panel');
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

    public function performer_panel ($page=null) {
        $count = DB::table('tracks')->select('tracks.*', 'users.name as performer_name', DB::raw('count(saves.id) as count_saves'))->join('users', 'tracks.performer_id', '=', 'users.id')->join('saves', 'tracks.id', '=', 'saves.track_id', 'left outer')->where('tracks.performer_id',  Auth::id())->groupBy('tracks.id')->latest()->get()->count();
        if ($count <= 10) {
            $tracks = DB::table('tracks')->select('tracks.*', 'users.name as performer_name', DB::raw('count(saves.id) as count_saves'))->join('users', 'tracks.performer_id', '=', 'users.id')->join('saves', 'tracks.id', '=', 'saves.track_id', 'left outer')->where('tracks.performer_id',  Auth::id())->groupBy('tracks.id')->latest()->get();
        }
        else {
            // dd($page);
            if ($page == null) {
                $tracks = DB::table('tracks')->select('tracks.*', 'users.name as performer_name', DB::raw('count(saves.id) as count_saves'))->join('users', 'tracks.performer_id', '=', 'users.id')->join('saves', 'tracks.id', '=', 'saves.track_id', 'left outer')->where('tracks.performer_id',  Auth::id())->groupBy('tracks.id')->latest()->take(10)->get();
            }
            else {
                
                $tracks = DB::table('tracks')->select('tracks.*', 'users.name as performer_name', DB::raw('count(saves.id) as count_saves'))->join('users', 'tracks.performer_id', '=', 'users.id')->join('saves', 'tracks.id', '=', 'saves.track_id', 'left outer')->where('tracks.performer_id',  Auth::id())->groupBy('tracks.id')->latest()->skip((intval($page)-1)*10)->take(10)->get();
                // dd($tracks);
            }
        }
        $data =  ['data'=>$tracks, 'count' => $count, 'page' => $page];
        return view('performer_panel', $data);
    }

    public function sfs_performer_panel (Request $request) {
        $data =  DB::table('tracks')->select('tracks.*', 'users.name as performer_name')->join('users', 'tracks.performer_id', '=', 'users.id')->where('tracks.performer_id',  Auth::id());
        if ($request->search != null && $request->search != '') {
           $data = $data->where('tracks.name', 'LIKE', '%'.$request->search.'%');
        }
        if ($request->sort != null && $request->sort != '') {
            $data = $data->orderBy('created_at', $request->sort);
        }
        // dd($data);
        $count = $data->latest()->get()->count();
        // dd($data);
        if ($count <= 10) {
            $data = $data->latest()->get();
        }
        else {
            if ($request->page == null) {
                $data = $data->latest()->take(10)->get();
            }
            else {
                $data = $data->latest()->skip((intval($request->page)-1)*10)->take(10)->get();
                // dd($tracks);
            }
        }
        $data = ['data'=>$data, 'count'=> $count, 'page'=> $request->page];
        return view('performer_panel', $data);
    }

    public function edit_track (Track $id) {
        $data =  ['data'=>$id];
        return view('edit_track', $data);
    }

    public function create_track () {
        return view('create_track');
    }

    public function create_track_db (Request $request) {
        // dd();
        $validator = Validator::make($request->all(), [
            "name"=>["required", "max:70"],
            "file_x"=>["required"],
        ],
        $messages = [
            'name.required' => 'Не введено название',
            'name.max' => 'Максимальная длина названия - 70 символов',
            'file_x.required' => 'Не отправлен файл аудиозаписи',
        ]
    );

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator);
    }
    else {
        if ($request->file_x->getClientOriginalExtension() == 'mp3') {

            $extention = $request->file('file_x')->getClientOriginalName();
            $request->file('file_x')->move(public_path() . '/audio', $extention);

            $track = Track::create(['name'=>$request->name,
                            'file'=>$extention,
                            'performer_id'=>Auth::id()]);
            return redirect()->route('performer_panel')->withErrors(['message' => 'Трек добавлен']);
        }
        else {
            return redirect()->back()->withErrors(['file_x' => 'Неверный формат файла аудиозаписи']);
        }
        
        
        
    }

    }

    public function edit_track_db (Request $request) {
        // dd();
        $validator = Validator::make($request->all(), [
            "name"=>["required", "max:70"],
        ],
        $messages = [
            'name.required' => 'Не введено название',
            'name.max' => 'Максимальная длина названия - 70 символов',
        ]
    );

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator);
    }
    else {
        if ($request->file('file_x') != null) {
        if ($request->file_x->getClientOriginalExtension() == 'mp3') {

            $extention = $request->file('file_x')->getClientOriginalName();
            $request->file('file_x')->move(public_path() . '/audio', $extention);

            $track = Track::where('id', $request->id)->update(['name'=>$request->name,
                            'file'=>$extention]);
            return redirect()->route('performer_panel')->withErrors(['message' => 'Информация о треке обновлена']);
        }
        else {
            return redirect()->back()->withErrors(['file_x' => 'Неверный формат файла аудиозаписи']);
        }
    }
    else {
        $track = Track::where('id', $request->id)->update(['name'=>$request->name,]);
        return redirect()->route('performer_panel')->withErrors(['message' => 'Информация о треке обновлена']);
    }    
        
    }

    }

    public function delete_track (Track $id) {
        $id->delete();
        return redirect()->back()->withErrors(['message' => 'Аудиозапись удалена']);
    }

    public function delete_track_admin (Track $id) {
        $id->delete();
        return redirect()->back()->withErrors(['message' => 'Аудиозапись удалена']);
    }


    public function admin_panel ($page=null) {
        $count = DB::table('tracks')->select('tracks.*', 'users.name as performer_name')->join('users', 'tracks.performer_id', '=', 'users.id')->latest()->get()->count();
        if ($count <= 10) {
            $tracks = DB::table('tracks')->select('tracks.*', 'users.name as performer_name')->join('users', 'tracks.performer_id', '=', 'users.id')->latest()->get();
        }
        else {
            // dd($page);
            if ($page == null) {
                $tracks = DB::table('tracks')->select('tracks.*', 'users.name as performer_name')->join('users', 'tracks.performer_id', '=', 'users.id')->latest()->take(10)->get();
            }
            else {
                
                $tracks = DB::table('tracks')->select('tracks.*', 'users.name as performer_name')->join('users', 'tracks.performer_id', '=', 'users.id')->latest()->skip((intval($page)-1)*10)->take(10)->get();
                // dd($tracks);
            }
        }
        $data =  ['data'=>$tracks, 'performers' => User::where('role', 'performer')->get(), 'count' => $count, 'page' => $page];
        return view('admin_panel', $data);
    }

    public function sfs_admin_panel (Request $request) {
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

        // dd($data);
        $count = $data->latest()->get()->count();
        // dd($data);
        if ($count <= 10) {
            $data = $data->latest()->get();
        }
        else {
            if ($request->page == null) {
                $data = $data->latest()->take(10)->get();
            }
            else {
                $data = $data->latest()->skip((intval($request->page)-1)*10)->take(10)->get();
                // dd($tracks);
            }
        }
        $data = ['data'=>$data, 'performers' => User::where('role', 'performer')->get(), 'count'=> $count, 'page'=> $request->page];
        return view('admin_panel', $data);
    }

    public function forget_pass () {
        return view('forget_pass');
    }

    public function forget_pass_db (Request $request) {
        $validator = Validator::make($request->all(), [
            "email"=>["required", "email"],
        ],
        $messages = [
            'email.required' => 'Не введена электронная почта',
            'email.email' => 'Неверный формат почты',
        ]
    );
    if ($validator->fails()) {
        return redirect()->route('forget_pass')->withErrors($validator);
    }
    else {

        $user = User::where('email', $request->email)->exists();
        if ($user != false) {
            $alphas = range('a', 'z');
            $alphas2 = range('A', 'Z');
            $new_pass = '';
            for ($j=0;$j<8;$j++) {
                $w = rand(0,2);
                if ($w == 0) {
                    $new_pass .= $alphas[rand(0,25)];
                }
                else if ($w == 1) {
                    $new_pass .= $alphas2[rand(0,25)];
                }
                else if ($w == 2) {
                    $new_pass .= strval(rand(0,9));

                }
            }
            if (mail(
                $request->email,
                'Восстановление пароля',
                "<html>
                 <body>
                <div>
                        <div>Ваш новый пароль - $new_pass</div>
                    </div>
                    <br>
    
                </body></html>",
                "From: ivan@example.com\r\n"
                ."Content-type: text/html; charset=utf-8\r\n"
                ."X-Mailer: PHP mail script"
            )) {
            User::where('email', $request->email)->update([
                'password' => Hash::make($new_pass),
            ]);
        return redirect()->route('login')->withErrors(['message' => 'Письмо с паролем отправлено на почту. Авторизуйтесь с новыми данными']);
               
            }
        else {
        return redirect()->back()->withErrors(['message' => 'Ошибка отправки письма']);

        }
    }
    else {
        return redirect()->route('forget_pass')->withErrors(['email' => 'Такого пользователя нет']);
    }
}
    }

    public function my_music ($page = null) {
        $count = DB::table('tracks')->select('tracks.*', 'users.name as performer_name')->join('users', 'tracks.performer_id', '=', 'users.id')->join('saves', 'tracks.id', '=', 'saves.track_id')->where('saves.user_id',  Auth::id())->latest()->get()->count();
        if ($count < 12) {
            $tracks = DB::table('tracks')->select('tracks.*', 'users.name as performer_name')->join('users', 'tracks.performer_id', '=', 'users.id')->join('saves', 'tracks.id', '=', 'saves.track_id')->where('saves.user_id',  Auth::id())->latest()->get();
        }
        else {
            // dd($page);
            if ($page == null) {
                $tracks = DB::table('tracks')->select('tracks.*', 'users.name as performer_name')->join('users', 'tracks.performer_id', '=', 'users.id')->join('saves', 'tracks.id', '=', 'saves.track_id')->where('saves.user_id',  Auth::id())->latest()->take(12)->get();
            }
            else {
                
                $tracks = DB::table('tracks')->select('tracks.*', 'users.name as performer_name')->join('users', 'tracks.performer_id', '=', 'users.id')->join('saves', 'tracks.id', '=', 'saves.track_id')->where('saves.user_id',  Auth::id())->latest()->skip((intval($page)-1)*12)->take(12)->get();
                // dd($tracks);
            }
        }
        $data =  ['data'=>$tracks,
    'performers' => User::where('role', 'performer')->get(), 'count' => $count, 'page' => $page];
        return view('my_music', $data);
    }

    public function delete_from_saves ($id) {
        DB::table('saves')->where('track_id', $id)->where('user_id', Auth::id())->delete();
        return redirect()->back()->withErrors(['message' => 'Аудиозапись удалена из вашей музыки']);
    }

    public function add_to_saves ($id) {
        Save::create([
            'track_id'=>$id,
            'user_id' => Auth::id(),
        ]);
        return redirect()->back()->withErrors(['message' => 'Аудиозапись добавлена в вашу музыку']);
    }

    public function sfs_my_music (Request $request) {
       
        $data =  DB::table('tracks')->select('tracks.*', 'users.name as performer_name')->join('users', 'tracks.performer_id', '=', 'users.id')->join('saves', 'tracks.id', '=', 'saves.track_id')->where('saves.user_id',  Auth::id());
        if ($request->search != null && $request->search != '') {
           $data = $data->where('tracks.name', 'LIKE', '%'.$request->search.'%');
        }
        if ($request->filter != null && $request->filter != '') {
            $data = $data->where('tracks.performer_id', '=', $request->filter);
        }
        if ($request->sort != null && $request->sort != '') {
            $data = $data->orderBy('created_at', $request->sort);
        }
        // dd($data);
        $count = $data->latest()->get()->count();
        // dd($data);
        if ($count <= 12) {
            $data = $data->latest()->get();
        }
        else {
            if ($request->page == null) {
                $data = $data->latest()->take(12)->get();
            }
            else {
                $data = $data->latest()->skip((intval($request->page)-1)*12)->take(12)->get();
                // dd($tracks);
            }
        }
        // dd($data);
        $data = ['data'=>$data, 'performers' => User::where('role', 'performer')->get(), 'count'=> $count, 'page'=> $request->page];
        return view('my_music', $data);
    }

    public function messages () {
        $friends = User::where('id',  Auth::id())->get();
        $friends = json_decode($friends[0]->friends);
        $users = User::get();
        if ($friends != null) {
            $friends = $friends->id;
        }
       
        // $friends = get_object_vars($friends);
        $messages = Message::where('from',  Auth::id())->orWhere('to', Auth::id())->get();
        $data =  ['data'=>$messages, 'friends'=>$friends, 'users' => $users, 'id' => 'empty'];
        return view('messages', $data);
    }

    public function messages_id ($id) {
        $friends = User::where('id',  Auth::id())->get();
        $friends = json_decode($friends[0]->friends);
        $users = User::get();
        if ($friends != null) {
            $friends = $friends->id;
        }
        // $friends = get_object_vars($friends);
        $messages = Message::where('from',  Auth::id())->orWhere('to', Auth::id())->get();
        $data =  ['data'=>$messages, 'friends'=>$friends, 'users' => $users, 'id' => $id];
        return view('messages', $data);
    }

    public function send_message (Request $request) {
        $messages = Message::create([
            "text" => $request->text,
            "to" => $request->to,
            "from" => Auth::id()
        ]);
        return redirect()->back();
    }

    public function friends ($page=null) {
        $friends = User::where('id',  Auth::id())->get();
        $friends = json_decode($friends[0]->friends);
        $users = User::get();
        if ($friends != null) {
            $friends = $friends->id;
            $count = count($friends);
        if ($count > 10) {
            if ($page == null) {
                $friends = array_slice($friends, 0, 10);
            }
            else {
                $friends = array_slice($friends, (intval($page)-1)*10, 10);

            }
        }
        }
        else {
            $count = 0;
        }
        // $friends = get_object_vars($friends);
        
        
        $data =  ['friends'=>$friends, 'users' => $users, 'count' => $count, 'page' => $page];
        return view('friends', $data);
    }

    public function sfs_friends (Request $request) {
        if ($request->search != null && $request->search != '') {
            $users = User::where('users.name', 'LIKE', '%'.$request->search.'%')->get();
         }
         else {
             $users = User::get();
         }

         $friends = User::where('id',  Auth::id())->get();
        $friends = json_decode($friends[0]->friends);
        if ($friends != null) {
            $friends = $friends->id;
            $count = count($friends);
        if ($count > 10) {
            if ($request->page == null) {
                $friends = array_slice($friends, 0, 10);
            }
            else {
                $friends = array_slice($friends, (intval($request->page)-1)*10, 10);

            }
        }
        }
        else {
            $count = 0;
        }
        // $friends = get_object_vars($friends);
        
        
        $data =  ['friends'=>$friends, 'users' => $users, 'count' => $count, 'page' => $request->page];
        return view('friends', $data);
    }

    public function delete_friend ($id) {
        $friends = User::where('id',  Auth::id())->get();
        $friends = json_decode($friends[0]->friends);
        $friends = $friends->id;
        // $friends = get_object_vars($friends);
        foreach ($friends as $key => $f) {
            if ($f == $id) {
                unset($friends[$key]);
            }
        }
        if ($friends == []) {
            $friends = null;
        } else {
            $friends = ['id' => array_values($friends)];
            $friends = json_encode($friends);
        }
        // dd($friends);
        User::where('id', Auth::id())->update([
            'friends' => $friends,
        ]);
        return redirect()->back()->withErrors(['message' => 'Пользователь удален из ваших друзей']);
    }

    public function add_friend ($id) {
        $friends = User::where('id',  Auth::id())->get();
        $friends = json_decode($friends[0]->friends);
        $friends = $friends->id;
        // $friends = get_object_vars($friends);
       
        array_push($friends,intval($id));
        
        if ($friends == []) {
            $friends = null;
        } else {
            $friends = ['id' => array_values($friends)];
            $friends = json_encode($friends);
        }
        // dd($friends);
        User::where('id', Auth::id())->update([
            'friends' => $friends,
        ]);
        return redirect()->back()->withErrors(['message' => 'Пользователь добавлен к вашим друзьям']);
    }

    public function search_friends ($page=null) {
        $users = User::where('id', '!=', Auth::id())->get();
        $friends = null;
        $count = 0;
        $data =  ['friends'=>$friends, 'users' => $users, 'count' => $count, 'page' => $page];
        return view('search_friends', $data);
    }

    public function sfs_search_friends (Request $request) {
        if ($request->search != null && $request->search != '') {
           $users = User::where('id', '!=', Auth::id())->where('users.name', 'LIKE', '%'.$request->search.'%')->get();
           $count = $users->count();
        }
        else {
            $users = User::where('id', '!=', Auth::id())->get();
            $count = $users->count();
        }
        $friends = User::where('id',  Auth::id())->get();
        $friends = json_decode($friends[0]->friends);
        if ($friends != null) {
            $friends = $friends->id;
        }
        $data =  ['friends'=>$friends, 'users' => $users, 'count' => $count, 'page' => $request->page];
        return view('search_friends', $data);
    }

    public function count_l_track (Request $request) {
      
        $track = Track::where('id', $request->id)->get();
        $count = $track[0]->count_l + 1;
        Track::where('id', $request->id)->update(['count_l' => $count]);
        $album = Album::where('id', $track[0]->album_id)->get();
        $count_album = $album[0]->count_l + 1;
        Album::where('id', $album[0]->id)->update(['count_l' => $count_album]);
        return 'Прослушивание засчитано';
    }
}
