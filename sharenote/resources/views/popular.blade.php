@extends('layouts.header')
@section('title', 'Моя музыка')
@section('content')


@error('message')
    <script>alert("{{ $message }}");</script>
@enderror

<div class="top_popular">
    <div class="top_headline c2 r1">Топ популярных сейчас треков</div>
    <div class="top_10 c2 r2">
        @php 
        $num = 0;
        @endphp
        @foreach ($data as $d) 
        @php 
        $num++;
        @endphp
        <div class="line_top">
            <div class="top_numbers c1"><div>{{$num}}</div></div>
        <div class="track_line c2">
            <div class="c1 r1-3 track_img"></div>
            <div class="c3 r1 track_name">{{$d->name}}</div>
            <div class="c3 r2 track_performer">{{$d->performer_name}}</div>
            <div class="c4 r1-3 track_length" id="dur_<?=$d->id?>"></div>
            <img class="c5 r1-3 play_img" src="{{asset('images/Polygon 4.svg')}}" onclick="play('<?=$d->file?>', '<?=$d->id?>')">
            <a href="{{asset('audio/'.$d->file)}}" download class="c7 r1-3"><img src="{{asset('images/download 2.svg')}}"></a>
            <img class="c9 r1-3" src="{{asset('images/Group 10.svg')}}" onclick="track_more('<?=$d->id?>')">
            <div class="c4-all r3 track_more" id="track_more_<?=$d->id?>">
                <div><a href="{{route('delete_from_saves', $d->id)}}" style="color:inherit; text-decoration:none;">Удалить из "Моей музыки"</a></div>
                <!-- <div class="void_small"></div>
                <div><div>Удалить из "Моей музыки"</div></div> -->
            </div>
        </div>
        </div>
        @endforeach
    </div>
</div>

<div class="void"></div>

<div class="main2">
    <div class="main2_headline c2 r1">Самые популярные альбомы</div>
    <div class="main2_desc c2 r2">Треки из этих альбомов слушали чаще всего</div>
    <div class="main2_albums c2 r3">
        @foreach ($albums as $a) 
        <div>
            <img src="{{asset('images/albums/'.$a->img)}}" class="main2_img">
            <div class="main2_name">{{$a->name}}</div>
        </div>
        @endforeach
    </div>
</div>
<div class="void"></div>
<div class="main2">
    <div class="main2_headline c2 r1">Самые популярные исполнители</div>
    <div class="main2_desc c2 r2">Больше всего прослушиваний за все время</div>
    <div class="main2_albums c2 r3">
        <div>
            <img src="{{asset('images/star 3.svg')}}" class="main2_img_round">
            <div class="main2_name">Исполнитель</div>
        </div>
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