<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
  <div class="list-group">
    @foreach($topCategory as $k => $v)
      <a href="{{url('search/cate/'.$v->id)}}" class="list-group-item @if(@$cateId == $v->id) active @endif">{{$v->cate_name}}</a>
    @endforeach
  </div>

  <div class="widget">
      <h4 class="title">标签云</h4>
      <div class="content tag-cloud">
          @foreach($tagList as $k => $v)
            <a href="{{url('search/tag/'.$v->id)}}" class="@if(@$tagId == $v->id) active @endif" title="{{$v->name}}">{{$v->name}}</a>
          @endforeach
      </div>
  </div>
  
  <section class="repo-card">
  <h4 class="title">友情链接</h4>
    <ul class="boxed-group-inner mini-repo-list">
      @if(!empty($linkList))
          @foreach($linkList as $link)
              <li class="public source ">
                  <a href="{{ $link->url }}" target="_blank"  class="mini-repo-list-item css-truncate">
                      <span class="repo-and-owner css-truncate-target">
                          {{ $link->name }}
                      </span>
                  </a>
              </li>
          @endforeach
      @endif
    </ul>
  </section>

</div><!--/.sidebar-offcanvas-->