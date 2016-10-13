@extends('admin.content.common')

@section('content')
        <div class="col-md-10">
            <div class="panel panel-default">
                {!! Notification::showAll() !!}
                <div class="panel-heading">分类管理</div>

                <div class="panel-body">
                    <a class="btn btn-success" href="{{ URL::route('admin.cate.create')}}">创建分类</a>

                    <table class="table table-hover table-top">
                        <tr>
                            <th>#</th>
                            <th>分类名称</th>
                            <th>创建时间</th>
                            <th class="text-right">操作</th>
                        </tr>

                        @foreach($cate as $k=> $v)
                        <tr>
                            <th scope="row">{{ $v->id }}</th>
                            <td>{{ $v->html}} {{ $v->cate_name }}</td>
                            <td>{{ $v->created_at }}</td>
                            <td class="text-right">




                                {!! Form::open([
                                'route' => array('admin.cate.destroy', $v->id),
                                'method' => 'delete',
                                'class'=>'btn_form',
                                'onsubmit'=>"return confirm('确定删除吗？')"
                                ]) !!}

                                <button type="submit" class="btn btn-danger" >
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                    删除
                                </button>

                                {!! Form::close() !!}

                                {!! Form::open([
                                    'route' => array('admin.cate.edit', $v->id),
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
            </div>
        </div>
@endsection
