@extends('layouts.header')
@section('title', 'Моя музыка')
@section('content')


@error('message')
    <div class="alert alert-success">{{ $message }}</div>
@enderror

@error('name')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

@error('email')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

@error('password')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

@error('password_old')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror


<div class="void"></div>
<div class="container">
<form action="{{route('lk')}}" method="post">
<h3>Личный кабинет</h3>
<div class="void"></div>
    @csrf
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Имя</label>
        <input type="text" class="form-control" name="name" value="{{$data[0]->name}}">
     </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Адрес электронной почты</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value="{{$data[0]->email}}">
    
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Старый пароль</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="password_old" placeholder="Введите текущий пароль">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Новый пароль</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Введите новый пароль">
  </div>
  <button type="submit" class="btn btn-primary" style="background-color:#764FAF; border:none;">Отправить</button>
</form>
</div>

@endsection