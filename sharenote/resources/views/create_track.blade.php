@extends('layouts.header')
@section('title', 'Моя музыка')
@section('content')


@error('message')
    <div class="alert alert-success">{{ $message }}</div>
@enderror

@error('name')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

@error('file_x')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror


<div class="void"></div>
<div class="container">
<form action="{{route('create_track_db')}}" method="post" enctype="multipart/form-data">
<h3>Создание трека</h3>
<div class="void"></div>
    @csrf
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Название</label>
        <input type="text" class="form-control" name="name">
     </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Аудиозапись</label>
    <input type="file" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="file_x"> 
  </div>
  <button type="submit" class="btn btn-primary" style="background-color:#764FAF; border:none;">Отправить</button>
</form>
</div>

@endsection