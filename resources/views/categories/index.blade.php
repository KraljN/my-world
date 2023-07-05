@extends('layouts.layout')

@section('keyword')
    category,categories,posts,my world, blog
@endsection

@section('title')
    {{$category->name}} | My World
@endsection

@section('description')
    All posts that belongs to single category
@endsection

@section('content')
    <horizontal-post-list
        type="categories"
        :object="{{json_encode($category)}}"
    ></horizontal-post-list>
@endsection

