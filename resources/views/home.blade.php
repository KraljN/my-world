@extends('layouts.layout')

@section('keyword')
    my,world,portal,home
@endsection

@section('title')
    Home | My World
@endsection

@section('description')
    Home page of My World portal
@endsection

@section('content')
    <home
    :posts="{{json_encode($posts)}}"
    >
    </home>
@endsection
