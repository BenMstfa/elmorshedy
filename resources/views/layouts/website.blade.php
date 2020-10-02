<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/logo-fiv.png') }}" type="" sizes="16x16">
    @yield('css')
    @if(config('app.locale') == 'ar')
        <link rel="stylesheet" href="{{ asset('css/style-rtl.css') }}">
    @endif

</head>
<body>


<style>

    .fundraise-main .days-main ul li.active-option {
        background: #ec6989 !important;
    }

    .fundraise-main .days-main ul li.active-option p {
        color: #fff !important
    }
</style>

<div class="container-fluid remove-padding head-main">
    <div class="container remove-padding">
        <div class="col-md-3 col-sm-3"><a href="#" data-scroll="home" class="scroll-to"><img src="img/logo_en.png"></a>
        </div>
        <span id="open-colse-menu-mob" class="visible-xs"></span>
        <div class="col-md-9 col-sm-9">
            <ul class="menu-main">
                <li><a href="#" data-scroll="home" class="scroll-to active-link"><p>{{ trans('app.Home') }}</p></a></li>
                <li><a href="#" data-scroll="about" class="scroll-to"><p>{{ trans('app.About Us') }}</p></a></li>
                <li><a href="#" data-scroll="Service" class="scroll-to"><p>{{ trans('app.Services') }}</p></a></li>
                <li><a href="#" data-scroll="Project" class="scroll-to"><p>{{ trans('app.Projects') }}</p></a></li>
                <li><a href="#" data-scroll="Contact" class="scroll-to"><p>{{ trans('app.Contact Us') }}</p></a></li>
            </ul>
            <ul class="social main">
                <li><a href="#"><i class="ri-facebook-fill"></i></a></li>
                <li><a href="#"><i class="ri-whatsapp-fill"></i></a></li>
                <li><a href="#"><i class="ri-phone-fill"></i></a></li>
                <li>
                    <a href="{{ route('language.switch', ['lang' => config('app.locale') == 'ar' ? 'en' : 'ar']) }}"
                       class="rtl-btn">
                        {{ config('app.locale') == 'ar' ? 'En' : 'Ar' }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

@yield('content')

<div class="container-fluid contact-main block" id="Contact">
    <div class="container remove-padding">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <h1>{{ trans('app.Contact Us') }} </h1>
            <p>{{ trans('app.Feel free to contact us on your queries and we will back to you as soon as possible') }}</p>
            <ul>
                <li><a href="#"><i class="ri-facebook-fill"></i> {{ trans('app.Our Facebook Page') }}</a></li>
                <li><a href="#"><i class="ri-mail-open-fill"></i> domain@gmail.com</a></li>
                <li><a href="#"><i class="ri-phone-fill"></i> 01102394387</a></li>
                <li><a href="#"><i class="ri-whatsapp-fill"></i> 01102394387</a></li>
                <li><a href="#"><i class="ri-phone-fill"></i> 01102394387</a></li>

            </ul>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <form>
                <div class="col-xs-12 remove-padding">
                    <input type="Your name" name="name" type="text" placeholder="your name">
                </div>

                <div class="col-xs-12 remove-padding">
                    <input type="Your emal" name="emal" type="emal" placeholder=" your email">
                </div>

                <div class="col-xs-12 remove-padding">
                    <textarea placeholder="you message"></textarea>
                </div>
                <button>Send <i class="ri-send-plane-fill"></i></button>
            </form>
        </div>

    </div>
</div>
<div class="container-fluid fot-main text-center">
    <p>Copyright © 2020</p>
</div>

<a href="https://api.whatsapp.com/send?phone=+201092329405&text=hi" class="float1" target="_blank">
    <i class="ri-whatsapp-fill my-float"></i>
</a>

<script src="{{ asset('js/jquery-1.11.2.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>

<script type="text/javascript">


    $(document).ready(function () {

        let urlParams = new URLSearchParams(window.location.search);

        if (urlParams.has('page')) {
            console.log("has page")
            $('.projects-link').trigger('click')
        }

        /*$('.tab').on('click', function (evt) {
            evt.preventDefault();
            $('.tab').removeClass('active');
            $(this).addClass('active');
            var sel = this.getAttribute('data-toggle-target');
            $('.tab-content').removeClass('active').filter(sel).addClass('active');
        });*/


        $('#open-colse-menu-mob, .scroll-to').on('click', function () {
            $('.head-main .col-md-9.col-sm-9').toggleClass('selected');
        });

        $("a.scroll-to").click(function (event) {
            event.preventDefault();
        });


        var lia = $("a.scroll-to");
        $(function () {

            $("body").css("paddingTop", $("nav").innerHeight() + -10);

            lia.click(function (e) {
                $(this).addClass("active-link").siblings().removeClass("active-link");
                $("html, body").animate({
                    scrollTop: $("#" + $(this).data("scroll")).offset().top - 75
                }, 1000);
            });

            $(window).scroll(function () {
                $(".block").each(function () {
                    if ($(window).scrollTop() > $(this).offset().top - 90) {
                        var blockId = $(this).attr("id");
                        $('a.scroll-to').removeClass("active-link");
                        if (!$('a.scroll-to[data-scroll="' + blockId + '"]').hasClass("active-link")) {
                            $('a.scroll-to[data-scroll="' + blockId + '"]').addClass("active-link")
                        }
                    }
                });
            });

        });

        $(document).on('click', '.project-navigation-tab', function (e) {
            e.preventDefault();

            window.location = $(this).attr('href')
        })
    });
</script>

@yield('scripts')
</body>
</html>
