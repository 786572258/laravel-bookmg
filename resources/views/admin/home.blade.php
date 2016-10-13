@extends('admin.app')

@section('modules') 
<div class="container-fluid">


	<div class="row">

        <div class="col-md-2">
            @include('admin._menu')
        </div>

		<div class="col-md-10">
			<div class="panel panel-default">
				<div class="panel-heading">☺</div>

				<div class="panel-body">
					欢迎使用
				</div>
			</div>
		</div>

	</div>
</div>
@endsection
