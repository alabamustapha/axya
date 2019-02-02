<dropdown-trigger class="h-9 flex items-center" slot-scope="{toggle}" :handle-click="toggle">
    <img class="rounded-full" src="{{ Auth::user()->avatar }}" width="25"> 
    {{-- <img src="https://secure.gravatar.com/avatar/{{ md5(auth()->user()->email) }}?size=512" class="rounded-full w-8 h-8 mr-3"/> --}}

    <span class="text-90 pl-2">
        {{ auth()->user()->name }}
    </span>
</dropdown-trigger>

<dropdown-menu slot="menu" width="200" direction="rtl">
    <ul class="list-reset">
        <li>
            @if (Auth::user()->isAdmin())
            <a href="{{ route('admin_dashboard') }}" class="block no-underline text-90 hover:bg-30 p-3">
                {{ __('Other Dashboard') }}
            </a>
            @endif
            <a href="{{ route('nova.logout') }}" class="block no-underline text-90 hover:bg-30 p-3">
                {{ __('Logout') }}
            </a>
        </li>
    </ul>
</dropdown-menu>
