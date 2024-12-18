<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>

<nav>
    <img src="{{asset('images/logo.svg')}}" class="c2 r1">
    <div class="logo_text c4 r1"><span style="color:black;">Share</span><span style="color:#764FAF;">Note</span></div>
    <div class="c1-all r1 navigation">
        <div>Главная</div>
        <div>Популярное</div>
        <div class="current_page">Моя музыка</div>
        <div>Исполнители</div>
        <div>Настройки</div>
    </div>
    <button class="c8 r1 violet_button">ВЫХОД</button>
    <div class="c4 r1 user_name">Puppy</div>
</nav>

@yield('content')

</body>
</html>