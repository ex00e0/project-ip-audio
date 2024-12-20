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
<h3>Восстановление пароля</h3>
<div class="void"></div>
<form action="{{route('forget_pass_db')}}" method="post">
    @csrf
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Адрес электронной почты для восстановления пароля</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
  </div>
  <button type="submit" class="btn btn-primary" style="background-color:#764FAF; border:none;">Отправить</button>
</form>
</div>
<div id="empty_px"></div>
@endsection