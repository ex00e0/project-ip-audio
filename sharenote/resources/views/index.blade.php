@extends('layouts.header')
@section('title', 'Моя музыка')
@section('content')


@error('message')
    <script>alert("{{ $message }}");</script>
@enderror

<div class="main1">
    <div class="main1_text c2 r1"><span class="text_in_text">Найдите свою музыку и друзей с </span><span class="share logo_in_text">Share</span><span class="note logo_in_text">Note</span></div>
    <div class="main1_desc c2 r2">
        <div>
            <img src="{{asset('images/star 3.svg')}}">
            <div>Слушайте множество треков с разными жанрами</div>
        </div>
        <div>
            <img src="{{asset('images/star 3.svg')}}">
            <div>Следите за новинками от исполнителей</div>
        </div>
        <div>
            <img src="{{asset('images/star 3.svg')}}">
            <div>Делитесь треками с друзьями</div>
        </div>
        <div>
            <img src="{{asset('images/star 3.svg')}}">
            <div>Смотрите, что сейчас слушают другие</div>
        </div>
    </div>
</div>

<div class="main2">
    <div class="main2_headline c2 r1">Новые альбомы</div>
    <div class="main2_desc c2 r2">Еще точно не слышали</div>
    <div class="main2_albums c2 r3">
        @foreach ($data as $d)
        <div>
            <img src="{{asset('images/albums/'.$d->img)}}" class="main2_img">
            <div class="main2_name">{{$d->name}}</div>
        </div>
        @endforeach
    </div>
</div>
<div class="void"></div>

<div id="empty_px"></div>



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

    function track_more (id) {
        let x = window.getComputedStyle(document.getElementById(`track_more_${id}`)).display == 'none';
        let arr = document.getElementsByClassName('track_more');
        // console.log(arr);
        for (key in arr) {
            if (key == 'length') {
                break;
            }
            document.getElementsByClassName('track_more')[key].style.display = 'none';
        }
        if (x) {
             document.getElementById(`track_more_${id}`).style.display = 'grid';
        }
        else {
            document.getElementById(`track_more_${id}`).style.display = 'none';
        }
       

    }
</script>
@endsection