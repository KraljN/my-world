@extends('layouts.layout')

@section('keyword')
    login,register,authentication,user,blog,my world,world
@endsection

@section('title')
    Login | My World
@endsection

@section('description')
    Login and registration page on My World portal
@endsection

@section('content')
    <login
        login_route="{{route('login')}}"
        register_route="{{route('register')}}"
    >
    </login>
@endsection
