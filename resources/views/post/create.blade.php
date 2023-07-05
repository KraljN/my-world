@extends('layouts.layout')

@section('keyword')
    post,posts,portal,blog,my world,my,world
@endsection

@section('title')
    Create Post | My World
@endsection

@section('description')
    Create new post
@endsection

@section('content')
    <post-modify
        :categories="{{json_encode($categories)}}"
        create_post_path="{{route('posts.store')}}"
        :tags="{{json_encode($tags)}}"
        :auth_user="{{auth()->user()}}"
    >
    </post-modify>
@endsection
