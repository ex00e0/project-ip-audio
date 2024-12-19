@extends('layouts.header')
@section('title', 'Моя музыка')
@section('content')

@error('name')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
@error('email')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

@error('password')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<div class="void"></div>
<div class="container">
<form action="{{route('reg')}}" method="post">
<h3>Регистрация</h3>
<div class="void"></div>
    @csrf
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Имя</label>
        <input type="text" class="form-control" name="name">
     </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Адрес электронной почты</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
    
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Пароль</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Роль</label>
    <select class="form-control" id="exampleInputPassword1" name="role">
        <option value="listener">слушатель</option>
        <option value="performer">исполнитель</option>
    </select>
  </div>
  <button type="submit" class="btn btn-primary" style="background-color:#764FAF; border:none;">Отправить</button>
</form>
</div>
<div id="empty_px"></div>
@endsection