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
<form class="sfs" action="{{route('sfs_admin_panel')}}" method="get" id="sfs">
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
    <input type="hidden" value="<?=($count > 10 ? $page : null)?>" name="page" id="page_move">
    <input type="submit" value="ИСКАТЬ" class="c8 r1 violet_button">
</form>

@if ($count != 0) 
@foreach ($data as $d) 
<div class="track_line">
    <div class="c1 r1-3 track_img"></div>
    <div class="c3 r1 track_name">{{$d->name}}</div>
    <div class="c3 r2 track_performer">{{$d->performer_name}}</div>
    <div class="c4 r1-3 track_length" id="dur_<?=$d->id?>"></div>
    <img class="c7 r1-3 play_img" src="{{asset('images/Polygon 4.svg')}}"  onclick="play('<?=$d->file?>', '<?=$d->id?>')">
    <!-- <a href="{{route('edit_track', $d->id)}}" class="c7 r1-3"><img src="{{asset('images/pencil 1.svg')}}"></a> -->
    <a href="{{route('delete_track_admin', $d->id)}}" class="c9 r1-3"><img src="{{asset('images/bin 1.svg')}}"></a>
</div>
<div class="void_small"></div>
@endforeach

@else
<div class="void_small" style="justify-self:center;">Нет таких треков</div>
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
            <div class="r1 current_page" style="font-size: 1.1vmax;"><a href="{{route('paginate_admin_panel', $i)}}" style="text-decoration:none; color: inherit;">{{$i}}</a></div>

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
            <div class="r1"><a href="{{route('paginate_admin_panel', $i)}}" style="text-decoration:none; color: inherit;">{{$i}}</a></div>

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

<div id="audio-player" style="position:fixed; width:100%; display:none;">
        
    </div>
<script>
    function play (name, id) {
        // console.log( document.getElementById('play_name'));
        let audio = document.createElement('audio');
        audio.setAttribute('controls', '');
        audio.setAttribute('style', 'width:100%;');
        audio.setAttribute('id', 'audio');
        audio.innerHTML = `<source id="play_name" src="{{asset('audio/${name}')}}" type="audio/mpeg">
            Your browser does not support the audio element.`;
        document.getElementById('audio-player').innerHTML = '';
        document.getElementById('audio-player').append(audio);

        // document.getElementById('play_name').setAttribute('type', 'audio/mpeg')
        // document.getElementById('play_name').setAttribute('src', '../../public/audio/' + name)
       
        document.getElementById('audio-player').style.display = 'block';
        document.getElementById('audio').play();
        document.getElementById('audio').onloadeddata = function(){console.log(document.getElementById('audio').duration);
        
        let min = Math.floor(document.getElementById('audio').duration/60);
        let sec = Math.floor(document.getElementById('audio').duration % 60);
        if (sec < 10) {sec = '0'+sec;}
        if (min < 10) {min = '0'+min;}
        let dur = min + ':' + sec;
        document.getElementById(`dur_${id}`).innerHTML = dur;
        };
        document.getElementById('empty_player').style.display = 'block';
       
    }
</script>

@endsection