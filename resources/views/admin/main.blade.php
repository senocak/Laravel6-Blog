<!doctype html>
<html lang="tr">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta charset="UTF-8">
		<title>@yield('title',"Anıl Şenocak - Personal Blog")</title>
        <link rel="stylesheet" href="/css/admin.main.css">
        <script src="{{url('/')}}/js/jquery-1.12.2.min.js"></script>
        <script src="{{url('/')}}/js/jquery-ui.min.js"></script>
        @yield('head')
    </head>
    <body>
        <div class="navbar">
            <ul dropdown>
                <li><a href="{{url('/')}}" target="_blank"><span class="fa fa-home"></span><span class="title">Siteyi Gör</span></a></li>
                <li><a><span class="fa fa-file"></span><span class="title">Yazılar</span></a>
                    <ul>
                        <li><a href="/admin/yazilar">Yazılar</a></li>
                        <li><a href="/admin/yazilar/ekle">Yeni Yazı</a></li>
                    </ul>
                </li>
                <li><a><span class="fa fa-plug"></span><span class="title">Kategoriler</span></a>
                    <ul>
                        <li><a href="/admin/kategoriler">Kategoriler</a></li>
                        <li><a href="/admin/kategoriler/ekle">Yeni Kategori</a></li>
                    </ul>
                </li>
                <li><a href="/admin/yorumlar"><span class="fa fa-comment"></span><span class="title">Yorumlar</span></a></li>
                <li style="float:right;"><a href="/admin/logout">Çıkış Yap <span class="fa fa-exclamation"></span></a></li>
                <li style="float:right;"><a href="/admin/profil"><span class="fa fa-cog"></span> {{ Auth::user()->name }}</a></li>
            </ul>
        </div>
        <div class="content">
            @yield('icerik')
        </div>
    </body>
    <script type="text/javascript">
        $(function () {
            $('[dropdown] >li').hover(function () {
                $('ul', this).show();
                $(this).addClass('active');
            }, function () {
                $('ul', this).hide();
                $(this).removeClass('active');
            });
        });
    </script>
    @yield('footer')
</html>