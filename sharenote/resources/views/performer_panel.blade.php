@extends('layouts.header')
@section('title', 'Моя музыка')
@section('content')


@error('message')
    <script>alert("{{ $message }}");</script>
@enderror
<div class="void"></div>
<div class="create_row">
    <button class="c2 r1 violet_button create_button"><a href="{{route('create_track')}}" style="text-decoration: none; color: white;">СОЗДАТЬ НОВЫЙ ТРЕК</a></button>
</div>
<form class="sfs" action="{{route('sfs_performer_panel')}}" method="get">
    <input name="search" type="text" placeholder="Введите название трека.." class="c2 r1" value="<?=(!isset($_GET['search']) || $_GET['search'] == '')?'':$_GET['search']?>">
   
    <select name="sort" class="c4-7 r1">
        <option value="" <?=(isset($_GET['sort']) && $_GET['sort'] == '')?'selected':''?>>-сортировка-</option>
        <option value="DESC" <?=(isset($_GET['sort']) && $_GET['sort'] == 'DESC')?'selected':''?>>сначала новые</option>
        <option value="ASC" <?=(isset($_GET['sort']) && $_GET['sort'] == 'ASC')?'selected':''?>>сначала старые</option>
    </select>
    <input type="submit" value="ИСКАТЬ" class="c8 r1 violet_button">
</form>

@if ($count != 0) 
@foreach ($data as $d) 
<div class="track_line">
    <div class="c1 r1-3 track_img"></div>
    <div class="c3 r1 track_name">{{$d->name}}</div>
    <div class="c3 r2 track_performer">{{$d->performer_name}}</div>
    <div class="c4 r1-3 track_length">00:00</div>
    <img class="c5 r1-3 play_img" src="{{asset('images/Polygon 4.svg')}}">
    <a href="{{route('edit_track', $d->id)}}" class="c7 r1-3"><img src="{{asset('images/pencil 1.svg')}}"></a>
    <a href="{{route('delete_track', $d->id)}}" class="c9 r1-3"><img src="{{asset('images/bin 1.svg')}}"></a>
</div>
<div class="void_small"></div>
@endforeach

@else
<div class="void_small" style="justify-self:center;">Нет таких треков</div>
@endif
<div id="empty_px"></div>
<!-- 
<div class="track_line">
    <div class="c1 r1-3 track_img"></div>
    <div class="c3 r1 track_name">Название трека</div>
    <div class="c3 r2 track_performer">Исполнитель</div>
    <div class="c4 r1-3 track_length">00:00</div>
    <img class="c5 r1-3 play_img" src="{{asset('images/Polygon 4.svg')}}">
    <img class="c7 r1-3" src="{{asset('images/download 2.svg')}}">
    <img class="c9 r1-3" src="{{asset('images/Group 10.svg')}}">
</div> -->


@endsection