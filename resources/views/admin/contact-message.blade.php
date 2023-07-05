@extends('layouts.layout')

@section('keyword')
    contact,message,user
@endsection

@section('title')
    Contact Messages | My World
@endsection
@section('description')
    Page for conversation with our customers
@endsection
@section('content')
    <contact-message
    :contact_messages="{{json_encode($contact_messages)}}"
    contact_messages_route="{{route("contact-message.admin.index")}}"
    >
    </contact-message>
@endsection
