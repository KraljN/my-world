<!DOCTYPE html>
<html>
    <head>
        @include('layouts.fixed.header')
    </head>
    <body>
            <div class="wrap d-flex flex-column" id="app">
                @include('layouts.fixed.navigation')

                <div class="container h-auto">
                    <div class="row w-100">
                        <div class="col-lg-8 main-content">
                            <div class="container mt-4 px-3 px-sm-5">
                                @yield('content')
{{--                                This part is used for search, it will be enabled when you type in something in search field--}}
                                <horizontal-post-list
                                    @if(auth()->user())
                                        :auth_user="{{auth()->user()}}"
                                        :roles="{{auth()->user()->getRoleNames()}}"
                                    @endif
                                >
                                </horizontal-post-list>
                                <notifications position="bottom left" width="100%" group="foo" />
                            </div>
                        </div>
                        <div class="col-lg-4 sidebar">
                            @include('layouts.fixed.aside')
                        </div>
                    </div>
                </div>
                @include('layouts.fixed.footer')
            </div>
        @include('layouts.fixed.scripts')
    </body>
</html>
