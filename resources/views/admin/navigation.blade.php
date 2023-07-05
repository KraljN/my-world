@extends('layouts.layout')

@section('keyword')
    menu,navigation,items,my world
@endsection

@section('title')
    Edit Navigation | My World
@endsection
@section('description')
    Page for manipulating navigation items
@endsection
@section('content')
    <navigation-edit
        :menu="{{json_encode($menu)}}"
        :available_navigation_items="{{json_encode($available_navigation_items)}}"
        :available_menu_items="{{json_encode($available_menu_items)}}"
        create_navigation_item_route="{{route('menus.store')}}"
        get_navigation_item_route="{{route('menus.index')}}"
        get_navigation_item_api_route="{{route('navigation-items')}}"
    >
    </navigation-edit>
@endsection

