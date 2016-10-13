@foreach($data as $v)
    {{$v}}<br>
@endforeach

@if($count>5)
    大于5
@else
    小于5
@endif