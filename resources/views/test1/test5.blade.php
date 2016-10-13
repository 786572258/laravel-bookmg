@extends("test1.layout.master")

1111111
@section("content")
    {!! HTML::image('images/01.jpg') !!}
    <img src="images/01.jpg">

    {!!HTML::linkRoute("test2_route")!!}
@stop

222222
@section('nav')
    @parent
    <li>在据页面的数据</li>

@stop

