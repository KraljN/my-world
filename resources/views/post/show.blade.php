@extends('layouts.layout')

@section('keyword')
    post,posts,portal,blog,my world,my,world
@endsection

@section('title')
    {{$post->title}} | My World
@endsection

@section('description')
    Single page for one post of My World portal
@endsection

@section('content')
    <post-show
        :post="{{json_encode($post)}}"
        :auth_user="{{json_encode($auth_user)}}"
        comments_route="{{route('comments.store')}}"
        login_route="{{route('login')}}"
    >
    </post-show>
@endsection

