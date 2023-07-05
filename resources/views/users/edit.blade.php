@extends('layouts.layout')

@section('keyword')
    edit,user,profile,my world,my,world
@endsection

@section('title')
    Edit Profile | My World
@endsection

@section('description')
    Page for editing profile of user
@endsection

@section('content')
    <user-edit
        :user="{{json_encode($user)}}"
        :roles="{{auth()->user()->getRoleNames()}}"
        :all_roles="{{json_encode($all_roles)}}"
        singed_route_for_resend_mail="{{route('verification.send', ['user' => $user])}}"
        @if(isset($message))
        message="{{$message}}"
        @endif
    >
    </user-edit>
@endsection
