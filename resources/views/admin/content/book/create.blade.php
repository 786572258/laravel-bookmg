@extends('admin.content.common')

@section('content')


<!-- Tokenfield CSS -->
<link href="{{ asset('/plugin/tags/css/bootstrap-tokenfield.css') }}" type="text/css" rel="stylesheet">
<link href="{{ asset('/plugin/tags/css/jquery-ui.css ') }}" type="text/css" rel="stylesheet">

        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">添加图书</div>

                @if ($errors->has('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <strong>Error!</strong>
                    {{ $errors->first('error', ':message') }}
                    <br />
                    请联系开发者！
                </div>
                @endif

                <div class="panel-body">
                    {!! Form::open(['route' => 'admin.book.store', 'method' => 'post','class'=>'form-horizontal','enctype'=>'multipart/form-data']) !!}
                        <div class="form-group">
                            <label for="inputBookname" class="col-sm-2 control-label">图书名称</label>
                            <div class="col-sm-7">
                                {!! Form::text('bookname', '', ['id' => 'inputBookname', 'class' => 'form-control','placeholder'=>'图书名称']) !!}
                                <font color="red">{{ $errors->first('bookname') }}</font>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputCate" class="col-sm-2 control-label">所属分类</label>
                            <div class="col-sm-7">
                                {!! Form::select('cid', $catArr , '' , ['class' => 'form-control', 'id' => 'inputCate']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPublisher" class="col-sm-2 control-label">发布商</label>
                            <div class="col-sm-7">
                                {!! Form::text('publisher', '', ['class' => 'form-control','placeholder'=>'发布商', 'id' => 'inputPublisher']) !!}
                                <font color="red">{{ $errors->first('publisher') }}</font>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputAuthor" class="col-sm-2 control-label">作者</label>
                            <div class="col-sm-7">
                                {!! Form::text('author', '', ['class' => 'form-control','placeholder'=>'作者', 'id' => 'inputAuthor']) !!}
                                <font color="red">{{ $errors->first('author') }}</font>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPrice" class="col-sm-2 control-label">价格</label>
                            <div class="col-sm-7">
                                {!! Form::text('price', '', ['class' => 'form-control','placeholder'=>'价格', 'id' => 'inputPrice']) !!}
                                <font color="red">{{ $errors->first('price') }}</font>
                            </div>
                        </div>
                        
                         <div class="form-group">
                            <label for="inputRecom" class="col-sm-2 control-label">推荐</label>
                            <div class="col-sm-7">
                                <div class="checkbox">
                                    <label>
                                        {!! Form::checkbox('recom', '1', ['class' => 'form-control','placeholder'=>'推荐', 'id' => 'inputRecom']) !!}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputTags" class="col-sm-2 control-label">标签</label>
                            <div class="col-sm-7">
                                {!! Form::text('tags', '', ['class' => 'form-control','placeholder'=>'回车确定','id'=>'inputTags']) !!}
                                <font color="red">{{ $errors->first('tags') }}</font>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="inputPic" class="col-sm-2 control-label">封面图</label>
                            <div class="col-sm-7">
                                {!! Form::file('pic', ['class' => 'control-label', 'id'=>'inputPic']) !!}
                                <font color="red">{{ $errors->first('pic') }}</font>
                                 <div class="row">
                                    <div class="col-sm-12 ">
                                        <img  id="imgPic" src="" class="img-thumbnail" alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                           
                

                        <div class="form-group">
                            <label for="inputContent" class="col-sm-2 control-label">内容</label>
                            <div class="col-sm-7 editor">
                                @include('editor::head')
                                {!! Form::textarea('content', '', ['class' => 'form-control','id'=>'myEditor']) !!}
                                <font color="red">{{ $errors->first('content') }}</font>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                {!! Form::submit('添加', ['class' => 'btn btn-success']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
<script type="text/javascript" src="{{ asset('/plugin/tags/jquery-ui.js ') }}"></script>
<script type="text/javascript" src="{{ asset('/plugin/tags/bootstrap-tokenfield.js ') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('/js/funs.js') }}" charset="UTF-8"></script>

<script type="text/javascript">
    $('#inputTags').tokenfield({
        autocomplete: {
            source: [<?php echo  \App\Model\Tag::getTagStringAll()?>],
            delay: 100
        },
        showAutocompleteOnFocus: !0,
        delimiter: [","]
    })

    $(function(){
        //上传看得到图片
        $("#inputPic").change(function(){
            var objUrl = getObjectURL(this.files[0]);            
            if (objUrl) {
                $("#imgPic").attr("src", objUrl).fadeIn();
            }
        });
    });
</script>
@endsection
