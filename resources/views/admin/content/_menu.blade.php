<div class="panel panel-default">
    <div class="panel-heading">导航</div>

    <div class="panel-body text-center">

        <ul class="nav nav-list">
            <li>
                <a href="{{URL::route('admin.book.index')}}">图书管理</a>
            </li>
            <li>
                <a href="{{URL::route('admin.cate.index')}}">分类管理</a>
            </li>

            <li>
                <a href="{{URL::route('admin.article.index')}}">文章管理</a>
            </li>

            <li>
                <a href="{{URL::route('admin.tags.index')}}">标签管理</a>
            </li>

        </ul>
    </div>
</div>