@extends('layouts.header')
@section('title', 'Моя музыка')
@section('content')

@error('email')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

@error('password')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

<div class="void"></div>
<div class="container">
<h3>Авторизация</h3>
<div class="void"></div>
<form action="{{route('login')}}" method="post">
    @csrf
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Адрес электронной почты</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
    
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Пароль</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
  </div>
  <button type="submit" class="btn btn-primary" style="background-color:#764FAF; border:none;">Отправить</button>
</form>
</div>
<div id="empty_px"></div>
@endsection