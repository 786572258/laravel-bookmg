@extends('admin.content.common')

@section('content')
    <div class="col-md-10">
        <div class="panel panel-default">
            {!! Notification::showAll() !!}
            <div class="panel-heading">图书列表</div>

            <div class="panel-body">

                <div class="pull-right navbar">
                   <a class="btn btn-success" href="{{ URL::route('admin.book.create')}}">添加图书</a>

                </div>
                <form class="form-inline" action="{{ URL::route('admin.book.index') }}" role="search">
                        {!! csrf_field() !!}
                        <div class="form-group ">
                            <input name="keyword" value="{{@$schParams['keyword']}}" type="text" class="form-control" placeholder="书名/作者">
                        </div>
                        <div class="form-group">
                            {!! Form::select('cid', $catArr, $schParams['cid'], ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group ">
                            <input type="text" name="priceStart" value="{{@$schParams['priceStart']}}" size="10" class="form-control " placeholder="起始价格">
                            -
                            <input type="text" name="priceEnd" value="{{@$schParams['priceEnd']}}" size="10" class="form-control " placeholder="结束价格">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default">检索</button>
                        </div>
                    
                </form>
                <!-- <input type="text" value="" /> -->
                <table class="table table-hover table-top table-cell-mid">
                    <tr>
                        <th>#</th>
                        <th>名称</th>
                        <th>所属分类</th>
                        <th>封面</th>
                        <th>作者</th>
                        <th>价格</th>
                        <th>推荐</th>
                        <th>发布商</th>
                        <th>发布日期</th>
                        <th class="text-right">操作</th>
                    </tr>

                    @foreach($books as $k => $v)
                    <tr>
                        <th scope="row" class="book-id" data-book-id="{{ $v->id }}">{{ $v->id }}</th>
                        <td class="bookname">{{ $v->bookname }}</td>
                        <td>{{ App\Model\Category::getCategoryNameByCatId($v->cid) }}</td>
                        <td class="book-pic"><img width="100" src="{{asset('/uploads/'.$v->pic)}}" alt="" /></td>
                        <td>{{ $v->author }}</td>
                        <td>{{ $v->price }}</td>
                        <td>@if ($v->recom == 1) 是 @else 否 @endif</td>
                        <td>{{ $v->publisher }}</td>
                        <td>{{ $v->created_at }}</td>
                        <td class="text-right">
                            {!! Form::open([
                                'route' => array('admin.book.destroy', $v->id),
                                'method' => 'delete',
                                'class'=>'btn_form'
                            ]) !!}
                            <button role="button"  data-toggle="modal" type="button" class="btn btn-default borrow-btn">
                                <span aria-hidden="true"></span>
                                借出
                            </button>
                            {!! Form::close() !!}

                            {!! Form::open([
                                'route' => array('admin.book.destroy', $v->id),
                                'method' => 'delete',
                                'class'=>'btn_form'
                            ]) !!}

                            <button type="submit"  onclick="return confirm('确定删除该图书吗')"  class="btn btn-danger">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                删除
                            </button>

                            {!! Form::close() !!}

                            {!! Form::open([
                                'route' => array('admin.book.edit', $v->id),
                                'method' => 'get',
                                'class'=>'btn_form'
                            ]) !!}

                            <button type="submit" class="btn btn-info">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                修改
                            </button>
                            {!! Form::close() !!}

                        </td>

                    </tr>
                    @endforeach
                </table>

            </div>
            {!! $books->appends($schParams)->render() !!}
        </div>

    </div>
    
    <div class="container ">
        <div class="row clearfix">
            <div class="col-md-12 column">
                <div class="modal fade " id="modal-container-507127" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="" class="borrow-form form-horizontal">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">
                                        <b>输入借书人信息</b>
                                    </h4>
                                </div>
                                 <div class="modal-header">
                                    <h4 class="modal-title" >
                                        <div>正在借出的图书：<span id="modal-bookname"></span></div>
                                    </h4>
                                    <h3 class="thumbnail">
                                        <img id="modal-book-pic" class="" width="80" src="" alt="" />
                                    </h3>
                                </div>
                                <div class="modal-body">
                                    <form action="" class="form-horizontal">
                                        <input type="hidden" name="book_id" id="input-book-id" value="" />
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <input type="text" name="name" class="form-control" placeholder="学生姓名"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <input type="text" name="number" class="form-control" placeholder="学生Id"/>
                                            </div>                                    
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                     <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button> 
                                     <button autocomplete="off" data-error-text="出错了!" data-complete-text="借出完成" data-exists-text="存在借书记录" data-loading-text="执行..." id="check-borrow-btn" type="button" class="btn btn-primary">确定借出</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<!-- <script type="text/javascript" src="{{ asset('/plugin/jquery-1.9.1.js ') }}"></script> -->
<script>
    $(function() {
        $(".borrow-btn").click(function() {
            var bookObj = $(this).parents('tr');
            $("#input-book-id").val(bookObj.find('.book-id').attr('data-book-id'));
            $("#modal-bookname").text(bookObj.find('.bookname').text());
            $("#modal-book-pic").attr('src', bookObj.find('.book-pic').children("img").attr('src'));
            $('#check-borrow-btn').button('reset');
            $("#modal-container-507127").modal();
        });

        $('#modal-container-507127').on('hidden.bs.modal', function (e) {
            $(".borrow-form")[0].reset();
        })
        
        $('#check-borrow-btn').bind('click', function () {
            var $this = $(this);
            var $btn = $this.button('loading');
            $.ajax({
                type: 'POST',
                url: "{{URL::route('admin.borrow.store')}}",
                data: $('.borrow-form').serialize(),
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function() {
                },
                success: function(d){
                    if (d == 1) {
                        $btn.button("complete");
                    } else if (d == 2) {
                        $btn.button("exists");
                    } else {
                        $btn.button("error");
                    }
                },
                error: function(xhr, type){
                    $btn.button("error");
                },
                complete: function(xhr, ts) {
                }
            });
        })
    });
</script>

@endsection