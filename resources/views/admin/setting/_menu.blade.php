<div class="panel panel-default">
    <div class="panel-heading">导航</div>

    <div class="panel-body text-center">

        <ul class="nav nav-list">
            <li>
                <a href="{{ url('/admin/system/index') }}">基本设置</a>
            </li>

            <li>
                <a href="{{ url(route('admin.nav.index')) }}">导航设置</a>
            </li>

            <li>
                <a href="{{ url(route('admin.links.index')) }}">友链管理</a>
            </li>

        </ul>
    </div>
</div>