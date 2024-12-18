@extends('layouts.header')
@section('title', 'Моя музыка')
@section('content')

<form class="sfs">
    <input name="search" type="text" placeholder="Введите название трека.." class="c2 r1">
    <select name="filter" class="c4 r1">
        <option>0</option>
    </select>
    <select name="sort" class="c6 r1">
        <option>0</option>
    </select>
    <input type="submit" value="ИСКАТЬ" class="c8 r1 violet_button">
</form>

<div class="track_line">
    <div></div>
</div>
{{$data->foo()->audio();}}

@endsection