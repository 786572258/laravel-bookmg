<div class="panel panel-default">
    <div class="panel-heading">菜单</div>

    <div class="panel-body text-center">

        <ul class="nav nav-list">
            <li>
                <a href="{{URL::route('admin.book.index')}}">图书管理</a>
            </li>
            <li>
                <a href="{{URL::route('admin.cate.index')}}">分类管理</a>
            </li>

            <li>
                <a href="{{URL::route('admin.borrow.index')}}">借书管理</a>
            </li>

            <li>
                <a href="{{URL::route('admin.tags.index')}}">标签管理</a>
            </li>
            <li>
                <a href="{{ url('/admin/system/index') }}">基本设置</a>
            </li>

            <li>
                <a href="{{ url(route('admin.nav.index')) }}">导航设置</a>
            </li>

            <li>
                <a href="{{ url(route('admin.links.index')) }}">友链管理</a>
            </li>
            <li>
                <a href="{{ URL::route('admin.user.index')}}">管理员列表</a>
            </li>

        </ul>
    </div>
</div>