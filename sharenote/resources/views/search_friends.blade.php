@extends('layouts.header')
@section('title', 'Моя музыка')
@section('content')


@error('message')
    <script>alert("{{ $message }}");</script>
@enderror
<div class="void"></div>
<div class="create_row">
    <button class="c2 r1 violet_button create_button"><a href="{{route('friends')}}" style="text-decoration: none; color: white;">НАЗАД</a></button>
</div>
<form class="sfs" action="{{route('sfs_search_friends')}}" method="get" id="sfs">
    <input name="search" type="text" placeholder="Введите имя.." class="c2-7 r1" value="<?=(!isset($_GET['search']) || $_GET['search'] == '')?'':$_GET['search']?>">

    <input type="hidden" value="<?=($count > 10 ? $page : null)?>" name="page" id="page_move">
    <input type="submit" value="ИСКАТЬ" class="c8 r1 violet_button">
</form>

@if ($friends != null) 
@foreach ($friends as $f)
@foreach ($users as $d) 
@if ($f == $d->id)
<div class="track_line">
    <div class="c1 r1-3 track_img"></div>
    <div class="c3 r1-3 track_name">{{$d->name}}</div>
    <a href="{{route('delete_friend', $d->id)}}" class="c9 r1-3"><img src="{{asset('images/bin 1.svg')}}"></a>
</div>
<div class="void_small"></div>
@endif
@endforeach
@endforeach

@else
<div class="void_small" style="justify-self:center;">Нет пользователей по такому запросу</div>
@endif
<div id="empty_px"></div>


@if ($count > 10)
<div class="pagination_block" id="pagination_block">
    <div></div>
    <div class="numbers_block">
        @php
        $amount = ceil($count/10);
        @endphp
        @for ($i=1;$i<=$amount;$i++)
            @if ($page != null && $i == $page)
            <?php
            if (isset($_GET['sort']) || isset($_GET['search'])) {
            ?>
            <div class="r1 current_page" style="font-size: 1.1vmax;"><a onclick="document.getElementById(`page_move`).value=`$i`;  document.getElementById(`sfs`).submit();" style="text-decoration:none; color: inherit;">{{$i}}</a></div>

            <?php
            } else {
            ?>
            <div class="r1 current_page" style="font-size: 1.1vmax;"><a href="{{route('paginate_friends', $i)}}" style="text-decoration:none; color: inherit;">{{$i}}</a></div>

            <?php
            }
            ?>
            @else
            <?php
            if (isset($_GET['sort']) || isset($_GET['search']) ) {
            ?>
            <div class="r1"><a onclick="document.getElementById(`page_move`).value=`{{$i}}`;  document.getElementById(`sfs`).submit();" style="text-decoration:none; color: inherit;">{{$i}}</a></div>

            <?php
            } else {
            ?>
            <div class="r1"><a href="{{route('paginate_friends', $i)}}" style="text-decoration:none; color: inherit;">{{$i}}</a></div>

            <?php
            }
            ?>
            @endif
        @endfor
        
    </div>
    <div></div>
</div>
<div class="void_small"></div>
@endif

@endsection