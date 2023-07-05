<aside class="mt-5 ">

    <author
        show="{{str_ends_with(url()->current(), 'contact')}}"
    >
    </author>
    @if(auth()->user() && auth()->user()->hasRole(['writer', 'admin']))
        <admin-tools
            posts_route="{{route('posts.index')}}"
            navigation_route="{{route('navigation.index')}}"
            tag_category_administration_route="{{route("tag-categories-administration")}}"
            contact_messages_route="{{route("contact-message.admin.index")}}"
            users_route="{{route("users.index")}}"
            :roles="{{json_encode(auth()->user()->getRoleNames())}}"
        >
        </admin-tools>
    @endif
    <popular-post :posts="{{json_encode($mostPopular)}}"></popular-post>
    <categories
        :categories="{{json_encode($categories)}}"
        category_route="{{route('categories.index')}}"
    >

    </categories>
    <tags
        :tags="{{json_encode($tags)}}"
        tag_route="{{route('tags.index')}}"
    >
    </tags>
</aside>
