@extends('themes.default.layouts')

@section('header')
    <title>搜索{{ $keyword }}</title>
    <meta name="keywords" content="{{ systemConfig('seo_key') }}" />
    <meta name="description" content="{{ systemConfig('seo_desc') }}">
@endsection

@section('content')
<div class="container">

  <div class="row row-offcanvas row-offcanvas-right">

    <div class="col-xs-12 col-sm-9">
      <p class="pull-right visible-xs">
        <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
      </p>

      <div class="jumbotron">
        <h2>搜索：{{ $keyword }}</h2>
        <p></p>
      </div>

      <div class="row">
        @foreach($bookList['data'] as $k => $v)
        <div class=" col-xs-6 col-lg-4">
          <div  class="thumbnail col-xs-12">
            <div class="col-xs-12">
              <h2 class="text-overflow">{{strCut($v->bookname,10)}}</h2>
              <h4 class="text-overflow">作者：{{strCut($v->author, 5)}}</h4>
              <p class=""> 
                <img class="" width="130" height="130"  src="{{asset('/uploads/'.$v->pic)}}" alt="" />
              </p>
              <p><a class="btn btn-default" href="{{url('book/'.$v->id)}}" role="button">详情 »</a></p>
            </div>
          </div>
        </div><!--/.col-xs-6.col-lg-4-->
        @endforeach
        
      </div><!--/row-->
    </div><!--/.col-xs-12.col-sm-9-->

    @include('themes.default.right')
  </div><!--/row-->

  <hr>
  <div class="pagination text-align">
      <nav>
         {!! $bookList['page']->render($page) !!}
      </nav>
  </div>
  <!-- /pagination -->
  <footer>
    <p>© maimai 2016</p>
  </footer>

</div><!--/.container-->
@endsection