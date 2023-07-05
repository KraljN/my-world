@extends('layouts.layout')

@section('keyword')
    tags,tag,my world,world
@endsection

@section('title')
    {{$tag->name}} | My World
@endsection

@section('description')
    Tag page for My World portal
@endsection

@section('content')
    <horizontal-post-list
        type="tags"
        :object="{{json_encode($tag)}}"
    ></horizontal-post-list>
@endsection

