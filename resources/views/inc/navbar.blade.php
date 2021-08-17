
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

        $expanded = false;
        $("#current_flag").click(function() {
            if ($expanded) {
                $expanded = false;
                $(".initial-hide").animate(
                    {
                    'width':'0px',
                    'min-width':'0px',
                    'max-width':'0px'
                    },
                    "slow",
                    function() {
                        $(".initial-hide").removeClass("visible-state");
                    }
                );
            } else {
                $expanded = true;
                $(".initial-hide").addClass("visible-state");
                $(".initial-hide").animate(
                    {
                        'width':'32px',
                        'min-width':'32px',
                        'max-width':'32px'
                    },
                    "slow"
                );
            }
        });

    });

    function changelang(lang) {
        console.log(lang);
        var url = window.location.href;    
        if (url.indexOf('?') > -1){
            url += '&lang='+lang
        }else{
            url += '?lang='+lang
        }
        window.location.href = url;
    }
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
                            {{--<li aria-haspopup="false"><a href="/settings">@lang('Inställningar')</a></li>--}}
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
                        <li aria-haspopup="false"><a href="/feedback">@lang('Feedback')</a></li>
                    </ul>
                </li>
                <li aria-haspopup="false"><a href="/about" class="{{ request()->is('about') ? 'active' : '' }}"></i>@lang('Info')</a></li>

                <img src="images/flags/{{get_locale_letters()}}.png" id="current_flag" />
                <div class="initial-hide">
                    @if(get_locale_letters() != 'en')
                        <img src="images/flags/en.png" onClick="changelang('en_US')" />
                    @endif
                    @if(get_locale_letters() != 'sv')
                        <img src="images/flags/sv.png" onClick="changelang('sv_SE')" />
                    @endif
                    @if(get_locale_letters() != 'lv')
                        <img src="images/flags/lv.png" onClick="changelang('lv_LV')" />
                    @endif
                    @if(get_locale_letters() != 'ro')
                        <img src="images/flags/ro.png" onClick="changelang('ro_RO')" />
                    @endif
                    @if(get_locale_letters() != 'es')
                        <img src="images/flags/es.png" onClick="changelang('es_ES')" />
                    @endif
                </div>

                <li class="search-wrapper" aria-haspopup="false"><select class="global-search"></select></li>
            </ul>
        </nav>
        <!--Menu HTML Code-->

    </div>
</div>

<div class="wsheader-fill"></div>
