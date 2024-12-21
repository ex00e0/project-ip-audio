@extends('layouts.header')
@section('title', 'Моя музыка')
@section('content')


@error('message')
    <div class="alert alert-success">{{ $message }}</div>
@enderror


<div class="void"></div>
<div class="mess_grid">
  <div class="c2 r1 friends_block">
    @if ($friends != null) 
    @foreach ($friends as $f)
    @foreach ($users as $u)
    @if ($u->id == $f)
    <div ><a href="{{route('messages_id', $u->id)}}" style="color:inherit; text-decoration:none;">{{$u->name}}</a></div>
    @endif
    @endforeach
    @endforeach

    @endif
    <!-- <div>friend 2</div>
    <div>friend 1</div>
    <div>friend 2</div>
    <div>friend 1</div>
    <div>friend 2</div>
    <div>friend 1</div>
    <div>friend 2</div>
    <div>friend 1</div>
    <div>friend 2</div>
    <div>friend 1</div>
    <div>friend 2</div>
    <div>friend 1</div>
    <div>friend 2</div> -->
  </div>
  
  <div class="c3 r1 messages_block" id="messages_block">
  @if ($friends != null) 
  @if ($id == 'empty')
    @foreach ($users as $u)
    @if ($u->id == $friends[0])
    <div class="r1 c1 header_mess"><div>Диалог с {{$u->name}}</div></div>
    @endif
    @endforeach
  @else 
  @foreach ($users as $u)
    @if ($u->id == $id)
    <div class="r1 c1 header_mess"><div>Диалог с {{$u->name}}</div></div>
    @endif
    @endforeach
  @endif
    

    @endif
    <div class="r2 c1 message" id="message">
    <div class="void"></div>
    @php
     $count_mess = 0;
     @endphp
    @if ($id == 'empty')
    @php
     $to = $friends[0];
     @endphp
    @foreach ($data as $d) 
     @if ($d->from == $friends[0] || $d->to == $friends[0])
     @php
     $count_mess ++;
     @endphp
     @if ($d->from == $friends[0])
     <div class="from">{{$d->text}}</div>
     <div class="void"></div>
     @else 
     <div class="to">{{$d->text}}</div>
     <div class="void"></div>
     @endif
    @endif
    @endforeach
    @if ($count_mess == 0)
    <div class="void" style="justify-self:center;">Сообщений еще нет..</div>
    @endif

    @else 
    @php
     $to = $id;
     @endphp
    @foreach ($data as $d) 
     @if ($d->from == $id || $d->to == $id)
     @php
     $count_mess ++;
     @endphp
     @if ($d->from == $id)
     <div class="from">{{$d->text}}</div>
     <div class="void"></div>
     @else 
     <div class="to">{{$d->text}}</div>
     <div class="void"></div>
     @endif
    @endif
    @endforeach
    @if ($count_mess == 0)
    <div class="void" style="justify-self:center;">Сообщений еще нет..</div>
    @endif

    @endif
      <!-- <div class="from">mess1</div>
      <div class="void"></div>
      <div class="to">mess2mess2mess2mess2mess2mess2mess2mess2mess2mess 2mess2mess2mess2mess2mess2mess2mess2mess2mess2mess2mess2</div>
      <div class="void"></div>
      <div class="from">mess1</div>
      <div class="void"></div>
      <div class="to">mess2mess2mess2mess2mess2mess2mess2mess2mess2mess 2mess2mess2mess2mess2mess2mess2mess2mess2mess2mess2mess2</div>
      <div class="void"></div>
      <div class="from">mess1</div>
      <div class="void"></div>
      <div class="to">mess2mess2mess2mess2mess2mess2mess2mess2mess2mess 2mess2mess2mess2mess2mess2mess2mess2mess2mess2mess2mess2</div>
      <div class="void"></div>
      <div class="from">mess1</div>
      <div class="void"></div>
      <div class="to">mess2mess2mess2mess2mess2mess2mess2mess2mess2mess 2mess2mess2mess2mess2mess2mess2mess2mess2mess2mess2mess2</div>
      <div class="void"></div> -->
    </div>
  
  </div>
  <form class="send_mess c3 r2" action="{{route('send_message')}}" method="post">
    @csrf
      <input type="text" class="form-control c1 r1" name="text">
      <input type="hidden" value="{{$to}}" name="to">
      <button type="submit" class="btn btn-primary c3 r1" style="background-color:#764FAF; border:none;">Отправить</button>
  </form>
  <label for="exampleInputPassword1" class="form-label c2 r2" style="align-self:center;"><a href="{{route('friends')}}" style="color:#764FAF">Управление списком друзей</a></label>
</div>
<div class="void"></div>
<div id="empty_px"></div>
<script>
  function scroll_top () {
    document.getElementById('message').scrollTop =  document.getElementById('message').scrollHeight;
  }
document.addEventListener('DOMContentLoaded', () => {
    scroll_top();
});
// function get_messages (id, name) {
//   alert(id);
//   document.getElementById('messages_block').innerHTML = '';
//   let div = document.createElement('div');
//   div.classList.add('r1');
//   div.classList.add('c1');
//   div.classList.add('header_mess');
//   div.innerHTML = `${name}`;
//   document.getElementById('messages_block').append(div);
//   let div2 = document.createElement('div');
//   div2.classList.add('r2');
//   div2.classList.add('c1');
//   div2.classList.add('message');
//   div2.setAttribute('id', 'message');
//   document.getElementById('messages_block').append(div2);
//     // Передаем ID в скрытое поле

//     // Обновляем содержимое блока с сообщениями
//     fetchMessages(id);
// }

// // Функция для обновления сообщений через AJAX
// function fetchMessages(id) {
//     fetch(`/messages/${id}`) // Замените на ваш маршрут
//         .then(response => response.text())
//         .then(data => {
//             document.getElementById('message').innerHTML = data;
//         });
// }
 
</script>
@endsection