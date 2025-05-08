@extends('layouts.header')
@section('title', 'Моя музыка')
@section('content')


@error('message')
    <script>alert("{{ $message }}");</script>
@enderror
<div class="void"></div>
<div class="perf_header">
    <div class="main2_headline c2 r1">Новости исполнителей</div>
</div>
<div class="void"></div>
<div class="perf_search">
    <input type="text" class="input_class c2 r1" placeholder="Поиск по тексту поста" oninput="search_posts_text()" id="search_posts_text">
    <input type="text" class="input_class c4 r1" placeholder="Поиск по исполнителю">
    <div class="search_button c2 r1">
        <img src="{{asset('images\search (1) 3.svg')}}">
    </div>
    <div class="search_button c4 r1">
        <img src="{{asset('images\search (1) 3.svg')}}">
    </div>
</div>
<div class="void"></div>
<div class="feed" id="feed">
    @foreach ($posts as $post)
    <div class="feed_block c2">
        <div class="feed_line_author c2 r2">
            <img src="{{asset('images/users/'.$post->performer_img)}}" class="c1 r1">
            <div class="feed_name c3 r1">{{$post->performer_name}}</div>
            <div class="feed_date c4 r1"><?=substr($post->created_at, 8, 2).'.'.substr($post->created_at, 5, 2).'.'.substr($post->created_at, 0, 4).substr($post->created_at, 10, 6)?></div> 
        </div>
        @if ($post->text != null)
        <div class="feed_text c2 r4">
            {{$post->text}}
        </div>
        @endif
        @if ($post->img != null && $post->text != null)
        <div class="void c2 r5"></div>
        @endif
        @if ($post->img != null)
        <img src="{{asset('images/posts/'.$post->img)}}" class="feed_img c2 r6">
        @endif
        @if (($post->img != null && $post->track_id != null) || ($post->text != null && $post->track_id != null))
        <div class="void c2 r7"></div>
        @endif
        @if ($post->track_id != null)
        <div class="feed_track c2 r8">
            <div class="track_line_feed">
                <div class="c1 r1-3 track_img_feed"></div>
                <div class="c3 r1 track_name">{{$post->name}}</div>
                <div class="c3 r2 track_performer">{{$post->performer_name}}</div>
                <div class="c4 r1-3 track_length" id="dur_<?=$post->track_id?>"></div>
                <img class="c5 r1-3 play_img" src="{{asset('images/Polygon 4.svg')}}" onclick="play('<?=$post->file?>', '<?=$post->track_id?>')">
                <a href="{{asset('audio/'.$post->file)}}" download class="c7 r1-3"><img src="{{asset('images/download 2.svg')}}"></a>
                <img class="c9 r1-3" src="{{asset('images/Group 10.svg')}}" onclick="track_more('<?=$post->track_id?>')">
                <div class="c4-all r3 track_more" id="track_more_<?=$post->track_id?>">
                    @if (isset($post->is_save))
                    @if ($post->is_save == 1)
                    <div><a href="{{route('delete_from_saves', $post->track_id)}}" style="color:inherit; text-decoration:none;">Удалить из "Моей музыки"</a></div>
                    @else
                    <div><a href="{{route('add_to_saves', $post->track_id)}}" style="color:inherit; text-decoration:none;">Добавить в "Мою музыку"</a></div>

                    @endif
                    @endif

                </div>
            </div>
        </div>
        @endif
        <div class="feed_likes c2 r9" >
            @if (isset($post->is_liked))
                @if ($post->is_liked == 1)
                <img id="likes_<?=$post->id?>" src="{{asset('images/red_heart.svg')}}" onclick="like_post(<?=$post->id?>, <?=isset($post->is_save)?>, 1)">
                @else
                <img id="likes_<?=$post->id?>" src="{{asset('images/Heart.svg')}}" onclick="like_post(<?=$post->id?>, <?=isset($post->is_save)?>, 0)">
                @endif
            @else
            <img id="likes_<?=$post->id?>" src="{{asset('images/Heart.svg')}}" onclick="like_post(<?=$post->id?>, 0, 0)">
            @endif
            <div class="c3" id="likes_num_<?=$post->id?>">{{$post->likes}}</div>
        </div>
    </div>
    <div class="void c2"></div>
    @endforeach
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
        document.getElementById('audio-player').style.bottom = '0vmax';

        document.getElementById('audio').play();
        document.getElementById('audio').onloadeddata = function(){
        
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

    function search_posts_text () {
        let text = document.getElementById('search_posts_text').value;
  $.ajax({
    url: "/search_posts_text",
    method: "POST",
    data: {text : text},
    success: (response)=>{

    let posts = response.posts;
    if (posts == undefined || posts == null || posts.length == 0 ) {
      let div_th = document.createElement('div');
      div_th.classList.add('no_posts');
      div_th.classList.add('c2');
      html_th = `
     Таких постов нет
      `;
      div_th.innerHTML = html_th;
      document.getElementById('feed').innerHTML = '';
      document.getElementById('feed').append(div_th);
     
     }
     else {
        document.getElementById('feed').innerHTML = '';
        $.each(posts, function(key, value){
            let post = value;
                let div = document.createElement('div');
                    div.classList.add('c2');
                    div.classList.add('feed_block');
                    html = `
                        <div class="feed_line_author c2 r2">
            <img src="{{asset('images/users/'.$post->performer_img)}}" class="c1 r1">
            <div class="feed_name c3 r1">{{$post->performer_name}}</div>
            <div class="feed_date c4 r1">${post.created_at.substr(8, 2)}` + '.' + post.created_at.substr(5, 2) + '.' + post.created_at.substr( 0, 4) + post.created_at.substr(10, 6) + `</div> 
        </div>`;
        if (post.text != null) {
        html += `<div class="feed_text c2 r4">
            ${post.text}
        </div>`;
        }
        if (post.img != null && post.text != null) {
        html += `<div class="void c2 r5"></div>`;
        }
        if (post.img != null) {
        html += `<img src="{{asset('images/posts/')}}` + '/' + post.img + `" class="feed_img c2 r6">`;
        }
        if ((post.img != null && post.track_id != null) || (post.text != null && post.track_id != null)) {
        html += `<div class="void c2 r7"></div>`;
        }
        if (post.track_id != null) {
        html += `<div class="feed_track c2 r8">
            <div class="track_line_feed">
                <div class="c1 r1-3 track_img_feed"></div>
                <div class="c3 r1 track_name">${post.name}</div>
                <div class="c3 r2 track_performer">${post.performer_name}</div>
                <div class="c4 r1-3 track_length" id="dur_${post.track_id}"></div>
                <img class="c5 r1-3 play_img" src="{{asset('images/Polygon 4.svg')}}" onclick="play('${post.file}', '${post.track_id}')">
                <a href="{{asset('audio/'.` + post.file + `)}}" download class="c7 r1-3"><img src="{{asset('images/download 2.svg')}}"></a>
                <img class="c9 r1-3" src="{{asset('images/Group 10.svg')}}" onclick="track_more('${post.track_id}')">
                <div class="c4-all r3 track_more" id="track_more_${post.track_id}">
                    @if (` + isset(post.is_save) + `)
                    @if (` + post.is_save + ` == 1)
                    <div><a href="{{route('delete_from_saves', ${post.track_id})}}" style="color:inherit; text-decoration:none;">Удалить из "Моей музыки"</a></div>
                    @else
                    <div><a href="{{route('add_to_saves', ${post.track_id})}}" style="color:inherit; text-decoration:none;">Добавить в "Мою музыку"</a></div>

                    @endif
                    @endif

                </div>
            </div>
        </div>`;
        }
        html += `<div class="feed_likes c2 r9">
            @if (` + isset(post.is_liked) + `)
                @if (` + post.is_liked + ` == 1)
                <img id="likes_${post.id}" src="{{asset('images/red_heart.svg')}}" onclick="like_post(${post.id}, 1, 1)">
                @else
                <img id="likes_${post.id}" src="{{asset('images/Heart.svg')}}" onclick="like_post(${post.id}, 1, 0)">
                @endif
            @else
            <img id="likes_${post.id}" src="{{asset('images/Heart.svg')}}" onclick="like_post(${post.id}, 0, 0)">
            @endif
            <div class="c3" id="likes_num_${post.id}">{{$post->likes}}</div>
        </div>
                    `;
                    
                    div.innerHTML = html;

                    let empty = document.createElement('div');
                    empty.classList.add('c2');
                    empty.classList.add('void');

                document.getElementById('feed').append(div);
                document.getElementById('feed').append(empty);
                });
     }
     if (document.body.scrollHeight < document.documentElement.clientHeight) {
        let diff = document.documentElement.clientHeight - document.body.scrollHeight;
        document.getElementById('empty_px').style.height = `${diff}px`;
    }
     
      },
      error: ()=>{
          console.log("Ошибка запроса!");
      }
  })
}

function like_post (id, auth_check, is_liked) {
    if (auth_check == 1) {
        if (is_liked == 0) {
            $.ajax({
                url: "/like_post",
                method: "POST",
                data: {id : id},
                success: (response)=>{
                    if (response == 'stop') {
                        console.log(response);
                    }
                    else {
                        document.getElementById(`likes_num_${id}`).innerHTML = response;
                        document.getElementById(`likes_${id}`).removeAttribute('src');
                        document.getElementById(`likes_${id}`).setAttribute('src', `{{asset('images/red_heart.svg')}}`);
                        document.getElementById(`likes_${id}`).removeAttribute('onclick');
                        document.getElementById(`likes_${id}`).setAttribute('onclick', `like_post(${id}, 1, 1)`);
                    }
                },
                error: ()=>{
                    console.log("Ошибка запроса!");
                }
            });
        }
        else {
            $.ajax({
                url: "/dislike_post",
                method: "POST",
                data: {id : id},
                success: (response)=>{
                    if (response == 'stop') {
                        console.log(response);
                    }
                    else {
                    document.getElementById(`likes_num_${id}`).innerHTML = response;
                    document.getElementById(`likes_${id}`).removeAttribute('src');
                    document.getElementById(`likes_${id}`).setAttribute('src', `{{asset('images/Heart.svg')}}`);
                    document.getElementById(`likes_${id}`).removeAttribute('onclick');
                    document.getElementById(`likes_${id}`).setAttribute('onclick', `like_post(${id}, 1, 0)`);
                    }
                },
                error: ()=>{
                    console.log("Ошибка запроса!");
                }
            });
        }
       
    }
    else {

    }
}
</script>
@endsection