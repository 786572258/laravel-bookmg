@extends('themes.default.layouts')

@section('header')
    <title>{{env('BOOKMG_NAME')}}</title>
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
      <div class="jumbotron row ">

        <div class="col-md-6">
            <h2 class="">{{strCut($book->bookname,30)}}</h2>
            <h4 class="">作者：{{strCut($book->author, 30)}}</h4>
        </div>
        <div class="col-md-6">
           <div>
                <img class="img-thumbnail" width="200"   src="{{asset('/uploads/'.$book->pic)}}" alt="" />
           </div>
        </div>
      </div>
        <article class="article-content markdown-body">
            {!! conversionMarkdown($book->content) !!}
        </article>
    </div><!--/.col-xs-12.col-sm-9-->
    @include('themes.default.right')

  </div><!--/row-->
</div><!--/.container-->
@endsection
