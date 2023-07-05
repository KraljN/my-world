@extends('layouts.layout')

@section('keyword')
    users,user,profiles,profile
@endsection

@section('title')
    Edit Users | My World
@endsection
@section('description')
    Page for manipulating with  all users in our blog
@endsection
@section('content')
    <users
    :users="{{json_encode($users)}}"
    users_route="{{route('users.index')}}"
    >
    </users>
@endsection
