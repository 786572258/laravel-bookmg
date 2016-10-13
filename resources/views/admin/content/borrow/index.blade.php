@extends('admin.content.common')

@section('content')
        <div class="col-md-10">
            <div class="panel panel-default">
                {!! Notification::showAll() !!}
                <div class="panel-heading">借书列表</div>
                <div class="panel-body">
                    <form class="form-inline" action="{{ URL::route('admin.borrow.index') }}" role="search">
                            {!! csrf_field() !!}
                            <div class="form-group ">
                                <input name="keyword" value="{{@$schParams['keyword']}}" type="text" class="form-control" placeholder="书名/作者">
                            </div>
                            <div class="form-group ">
                                <input name="name_or_number" value="{{@$schParams['name_or_number']}}" type="text" class="form-control" placeholder="借阅人/学号">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-default">搜索</button>
                            </div>
                    </form>
                    <!-- <input type="text" value="" /> -->
                    <table class="table table-hover table-top table-cell-mid">
                        <tr>
                            <th>#</th>
                            <th>借阅人</th>
                            <th>学号</th>
                            <th>书本</th>
                            <th>借书时间</th>
                            <th>状态</th>
                            <th class="text-right"></th>
                        </tr>

                        @foreach($borrows as $k => $v)
                        <tr>
                            <th scope="row">{{ $v->id }}</th>
                            <td>{{ $v->name }}</td>
                            <td>{{ $v->number }}</td>
                            <td>{{ $v->bookname }} | {{ $v->author }}</td>
                            <td>{{ $v->created_at }}</td>

                            @if ($v->status == 0) 
                                <td role="presentation" class="dropdown ">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                        未归还<span class="caret"></span>
                                    </a>
                                   <ul class="dropdown-menu" role="menu">
                                     <li>
                                         <a href="{{url('admin/borrow/bookReturn/'.$v->id)}}">设置为 “已归还”</a>
                                     </li>
                                   </ul>
                                </td>
                            @else
                                <td>已归还</td>
                            @endif
                            <td class="text-right">

                                {!! Form::open([
                                    'route' => array('admin.borrow.destroy', $v->id),
                                    'method' => 'delete',
                                    'class'=>'btn_form'
                                ]) !!}
                                
                                {!! Form::close() !!}

                                {!! Form::open([
                                    'route' => array('admin.borrow.edit', $v->id),
                                    'method' => 'get',
                                    'class'=>'btn_form'
                                ]) !!}

                               
                                {!! Form::close() !!}

                            </td>

                        </tr>
                        @endforeach
                    </table>

                </div>
                {!! $borrows->appends($schParams)->render() !!}
            </div>

        </div>
@endsection