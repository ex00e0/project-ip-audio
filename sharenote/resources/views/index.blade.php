@extends('layouts.header')
@section('title', 'Моя музыка')
@section('content')


@error('message')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror


<form class="sfs" action="{{route('sfs')}}" method="get" id="sfs">
    <input name="search" type="text" placeholder="Введите название трека.." class="c2 r1" value="<?=(!isset($_GET['search']) || $_GET['search'] == '')?'':$_GET['search']?>">
    <select name="filter" class="c4 r1">
        <option value="" <?=(isset($_GET['filter']) && $_GET['filter'] == '')?'selected':''?>>-фильтрация по исполнителям-</option>
        @foreach ($performers as $p) 
        <option value="{{$p->id}}" <?=(isset($_GET['filter']) && $_GET['filter'] == $p->id)?'selected':''?>>{{$p->name}}</option>
        @endforeach
    </select>
    <select name="sort" class="c6 r1">
        <option value="" <?=(isset($_GET['sort']) && $_GET['sort'] == '')?'selected':''?>>-сортировка-</option>
        <option value="DESC" <?=(isset($_GET['sort']) && $_GET['sort'] == 'DESC')?'selected':''?>>сначала новые</option>
        <option value="ASC" <?=(isset($_GET['sort']) && $_GET['sort'] == 'ASC')?'selected':''?>>сначала старые</option>
    </select>
    <input type="hidden" value="<?=($count >= 12 ? $page : null)?>" name="page" id="page_move">
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
    <a href="{{asset('audio/'.$d->file)}}" download class="c7 r1-3"><img src="{{asset('images/download 2.svg')}}"></a>
    <img class="c9 r1-3" src="{{asset('images/Group 10.svg')}}">
</div>
<div class="void_small"></div>
@endforeach

@else
<div class="void_small" style="justify-self:center;">Нет таких треков</div>
@endif
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
<div id="empty_px"></div>

@if ($count > 12)
<div class="pagination_block" id="pagination_block">
    <div></div>
    <div class="numbers_block">
        @php
        $string = 
        $amount = ceil($count/12);
        @endphp
        @for ($i=1;$i<=$amount;$i++)
            @if ($page != null && $i == $page)
            <?php
            if (isset($_GET['sort']) || isset($_GET['search']) || isset($_GET['filter'])) {
            ?>
            <div class="r1 current_page" style="font-size: 1.1vmax;"><a onclick="document.getElementById(`page_move`).value=`$i`;  document.getElementById(`sfs`).submit();" style="text-decoration:none; color: inherit;">{{$i}}</a></div>

            <?php
            } else {
            ?>
            <div class="r1 current_page" style="font-size: 1.1vmax;"><a href="{{route('paginate', $i)}}" style="text-decoration:none; color: inherit;">{{$i}}</a></div>

            <?php
            }
            ?>
            @else
            <?php
            if (isset($_GET['sort']) || isset($_GET['search']) || isset($_GET['filter'])) {
            ?>
            <div class="r1"><a onclick="document.getElementById(`page_move`).value=`{{$i}}`;  document.getElementById(`sfs`).submit();" style="text-decoration:none; color: inherit;">{{$i}}</a></div>

            <?php
            } else {
            ?>
            <div class="r1"><a href="{{route('paginate', $i)}}" style="text-decoration:none; color: inherit;">{{$i}}</a></div>

            <?php
            }
            ?>
            @endif
        @endfor
        
        
        <!-- <div class="r1"><a href="{{route('paginate', 2)}}" style="text-decoration:none; color: inherit;">2</a></div> -->
    </div>
    <div></div>
</div>
<div class="void_small"></div>
@endif

@endsection