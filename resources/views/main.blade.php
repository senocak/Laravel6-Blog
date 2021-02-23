<!DOCTYPE html>
<html lang="tr">
    <head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>@yield('title',"Anıl Şenocak - Personal Blog")</title>
		<meta itemprop="description" content="Anıl Şenocak - Personal Blog">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="author" content="Anıl Şenocak">
		<meta name="description" content="Anıl Şenocak - Personal Blog" />
        <link rel="stylesheet" href="{{url('/')}}/css/main.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        @yield('stylesheet')
    </head>
    <body class="dark-theme">
        <header class="header" style="padding: 20px;width: 100%;z-index: 1;position: fixed;">
            <span class="header__inner">
                <a href="{{url('/')}}" style="text-decoration: none;">
                    <div class="logo">
                        <span class="logo__mark">></span>
                        <span class="logo__text">$ cd /home/</span>
                        <span class="logo__cursor" style=""></span>
                    </div>
                </a>
                <nav class="menu" style="border-right: none !important;top:0px">
                    <ul class="menu__inner" style="flex-direction: row;">
                        <li class="menu_blog_li"><a href="/blog">Blog</a></li>
                    </ul>
                </nav>
            </span>
        </header>
        @yield('icerik')
        <footer class="footer">
            <div class="footer__inner">
                <div class="footer__content">
                    <span>Made with &#10084; by <a href="http://github.com/senocak" target="_blank">Anıl Şenocak</a></span>
                </div>
            </div>
        </footer>
        @yield('footer')
    </body>
</html>
