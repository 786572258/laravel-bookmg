{{-- 表单学习 --}}
{!!Form::open(['url'=>'/test7'])!!}
    {!!Form::token()!!}
    {!!Form::label('name', '用户名')!!}
    {!!Form::text('name', '', ['class'=>'input-block-level'])!!}
    {!!Form::label('password', '密码')!!}
    {!!Form::password('password', '', ['class'=>'input-block-level'])!!}
    {!!Form::select('bg_color', ['black'=>'#000', 'white'=>'#FFF'])!!}
    {!!Form::text('category_info', '', ['class'=>'input-block-level'])!!}
    {!!Form::submit('确认', ['class'=>'btn btn-success'])!!}
{!!Form::close()!!}