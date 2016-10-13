<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @yield('header')
        <link rel="icon" href="../../favicon.ico">
        <!-- Bootstrap core CSS -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="{{ homeAsset('/css/components/offcanvas.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ homeAsset('/css/pages/index.css?a=a') }}">
        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]>
            <script src="//v3.bootcss.com/assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->
        <script src="{{ homeAsset('/js/ie-emulation-modes-warning.js') }}"></script>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <nav class="navbar navbar-fixed-top navbar-inverse" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{url('/')}}">{{env('BOOKMG_NAME')}}</a></div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active">
                            <a href="/">Home</a></li>@if(!empty($navList)) @foreach($navList as $nav)
                        <li>
                            <a href="{{ $nav->url }}">{{ $nav->name }}</a></li>@endforeach @endif
                        <li>
                            <form class="demo_search" action="{{url('search/keyword')}}" method="get">
                                <i class="glyphicon glyphicon-search" id="open"></i>
                                <input class="demo_sinput form-control " type="text" name="keyword" id="search_input" placeholder="输入关键字 回车搜索">
                            </form>
                        </li>
                    </ul>
                </div><!-- /.nav-collapse -->
            </div><!-- /.container -->
        </nav><!-- /.navbar -->
        @yield('content')

        <div class="container">
            <footer>
              <p>© maimai 2016</p>
            </footer>
        </div>
        
        <!-- Bootstrap core JavaScript================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="{{ homeAsset('/vendor/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="{{ homeAsset('/js/ie10-viewport-bug-workaround.js') }}"></script>
        <script src="{{ homeAsset('/js/offcanvas.js') }}"></script>
        <script>
            jQuery(document).ready(function($) {
                // geopattern
                $('.geopattern').each(function() {
                    $(this).geopattern($(this).data('pattern-id'));
                });

                $("#open").mouseover(function() {
                    $("#search_input").fadeIn(1).animate({
                        width: '300px',
                        opacity: '10'
                    });
                    $("#search_input")[0].focus();
                    $("#open").fadeOut(10);
                });

                $("#search_input").blur(function() {
                    $("#search_input").animate({
                        width: 'toggle',
                        opacity: '0.1'
                    }).fadeOut(2);
                    $("#open").delay(400).fadeIn(100);
                });
                //$('.share-bar').share();
            });
        </script>
    </body>
</html>