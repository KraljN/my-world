@extends('layouts.layout')

@section('keyword')
    post,posts,portal,blog,my world,my,world,update,edit
@endsection

@section('title')
    Edit Post | My World
@endsection

@section('description')
    Page for editing post details
@endsection

@section('content')
    <post-modify
        :categories="{{json_encode($categories)}}"
        create_post_path="{{route('posts.store')}}"
        :tags="{{json_encode($tags)}}"
        :auth_user="{{auth()->user()}}"
        :post="{{json_encode($post)}}"
        :users="{{json_encode($users)}}"
        :roles="{{json_encode($roles)}}"
    >
    </post-modify>
@endsection
