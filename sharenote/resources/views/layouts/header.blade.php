<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>

<nav>
    <img src="{{asset('images/logo.svg')}}" class="c2 r1">
    <div class="logo_text c4 r1"><span style="color:black;">Share</span><span style="color:#764FAF;">Note</span></div>
    <div class="c1-all r1 navigation">
        <div><a href="{{route('/')}}" style="text-decoration: none; color: inherit;">Главная</a></div>
        <div>Популярное</div>
        @auth
        <div class="current_page">Моя музыка</div>
        <div><a href="{{route('lk')}}" style="text-decoration: none; color: inherit;">Личный кабинет</a></div>
        @if (Auth::user()->role == 'admin')
        <div><a href="" style="text-decoration: none; color: inherit;">Панель администратора</a></div>
        @elseif ( Auth::user()->role == 'performer')
        <div><a href="{{route('performer_panel')}}" style="text-decoration: none; color: inherit;">Панель исполнителя</a></div>
        @endif
       
        @endauth
        
        
        <!-- <div>Настройки</div> -->
    </div>
    @auth
    <button class="c8 r1 violet_button"><a href="{{route('exit')}}" style="text-decoration: none; color: white;">ВЫХОД</a></button>
    <!-- <div class="c4 r1 user_name">Puppy</div> -->
    @endauth
    @guest 
    <button class="c4-7 r1 violet_button reg"><a href="{{route('reg')}}" style="text-decoration: none; color: white;">РЕГИСТРАЦИЯ</a></button>
    <button class="c8 r1 violet_button"><a href="{{route('login')}}" style="text-decoration: none; color: white;">ВХОД</a></button>
    @endguest
</nav>

@yield('content')

<footer>
    <div class="copyright c2 r1">© ООО “ShareNote”, 2024 </div>
    <img src="{{asset('images/logo.svg')}}" class="c3 r1">
    <div class="logo_text_footer c4 r1"><span style="color:black;">Share</span><span style="color:#764FAF;">Note</span></div>
</footer>
<script>
    // alert();
    if (document.body.scrollHeight < document.documentElement.clientHeight) {
        let diff = document.documentElement.clientHeight - document.body.scrollHeight;
        document.getElementById('empty_px').style.height = `${diff}px`;
    }
</script>
</body>
</html>