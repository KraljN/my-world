<navigation
    :menu="{{json_encode($menu)}}"
    login_route="{{route('login')}}"
    logout_route="{{route('logout')}}"
    get_navigation_item_route="{{route('menus.index')}}"
    :auth_user="{{json_encode(Auth::user())}}"
>
</navigation>
