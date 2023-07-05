<script type="text/javascript" src="{{asset("assets/js/app.js")}}"></script>
<script>
    @auth
        window.Permissions = {!! json_encode(auth()->user()->getRoleNames(), true) !!};
    @else
        window.Permissions = [];
    @endauth
</script>

