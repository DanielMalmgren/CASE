
<script>
    $(function() {
        $('.global-search').select2({
            width: '200px',
            placeholder: "@lang('Sök')",
            ajax: {
                url: '/select2search',
                dataType: 'json'
            },
            language: "{{substr(App::getLocale(), 0, 2)}}",
            minimumInputLength: 3,
            theme: "bootstrap4"
        });

        $('.global-search').on('select2:select', function (e) {
            window.location = e.params.data.url;
        });
    });
</script>

<!-- Mobile Header -->
<div class="wsmobileheader clearfix ">
    <a id="wsnavtoggle" class="wsanimated-arrow"><span></span></a>
    <span class="smllogo"><a href="#"><img src="{{env('HEADER_LOGO')}}"></a></span>
</div>
<!-- Mobile Header -->

<div class="wsmainfull clearfix">
    <div class="wsmainwp clearfix">

        <div class="desktoplogo"><a href="/"><img src="{{env('HEADER_LOGO')}}"></a></div>

        <!--Main Menu HTML Code-->
        <nav class="wsmenu clearfix">
            <ul class="wsmenu-list">
                <li aria-haspopup="false"><a href="/" class="menuhomeicon {{ request()->is('/') ? 'active' : '' }}"><i class="fa fa-home"></i><span class="hometext">&nbsp;&nbsp;@lang('Hem')</span></a></li>
                <li aria-haspopup="false"><a href="/tracks" class="{{ request()->is('tracks') ? 'active' : '' }}"></i>@lang('Spår')</a></li>
                @hasrole('Admin')
                    <li aria-haspopup="true"><a href="#"><i class="fa fa-angle-right"></i>@lang('Administration')</a>
                        <ul class="sub-menu">
                            @can('use administration')
                                @can('manage users')
                                    <li aria-haspopup="false"><a href="/users">@lang('Användare')</a></li>
                                @endcan
                                @hasrole('Admin')
                                    <li aria-haspopup="false"><a href="/poll">@lang('Hantera enkäter')</a></li>
                                @endhasrole
                            @endcan
                            {{--<li aria-haspopup="false"><a href="/statistics">@lang('Statistik')</a></li>--}}
                        </ul>
                    </li>
                @endhasrole
                @auth
                    <li aria-haspopup="true"><a href="#"><i class="fa fa-angle-right"></i>{{Auth::user()->firstname}}</a>
                        <ul class="sub-menu">
                            <li aria-haspopup="false"><a href="/settings">@lang('Inställningar')</a></li>
                            <li aria-haspopup="false"><a href="/feedback">@lang('Feedback')</a></li>
                            <li aria-haspopup="false"><a href="/logout" id="logout">@lang('Logga ut')</a></li>
                        </ul>
                    </li>
                @endauth
                @guest
                    <li aria-haspopup="false"><a href="/login">@lang('Logga in')</a></li>
                @endguest
                <li aria-haspopup="true"><a href="#"><i class="fa fa-angle-right"></i>@lang('Hjälp')</a>
                    <ul class="sub-menu">
                        <li aria-haspopup="false"><a target="_blank" href="/pdf/CASE%20users%20manual.pdf">@lang('Användarmanual')</a></li>
                        @can('edit lessons')
                            <li aria-haspopup="false"><a target="_blank" href="/pdf/CASE%20editors%20manual.pdf">@lang('Editors manual')</a></li>
                        @endcan
                        @hasrole('Admin')
                            <li aria-haspopup="false"><a target="_blank" href="/pdf/Evikomp%20intern%20manual.pdf">@lang('Intern manual')</a></li>
                        @endhasrole
                    </ul>
                </li>
                <li aria-haspopup="false"><a href="/about" class="{{ request()->is('about') ? 'active' : '' }}"></i>@lang('Info')</a></li>
                <li class="search-wrapper" aria-haspopup="false"><select class="global-search"></select></li>
            </ul>
        </nav>
        <!--Menu HTML Code-->

    </div>
</div>

<div class="wsheader-fill"></div>
