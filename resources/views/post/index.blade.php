@extends('layouts.layout')

@section('keyword')
    post,posts,portal,blog,my world,my,world
@endsection

@section('title')
    Posts | My World
@endsection

@section('description')
    List of all current posts
@endsection

@section('content')
    <admin-post
        :roles="{{json_encode($roles)}}"
        :auth_user="{{json_encode(auth()->user())}}"
        create_post_route="{{route('posts.create')}}"
        all_posts_route="{{route('posts.index')}}"
    >
    </admin-post>
@endsection
