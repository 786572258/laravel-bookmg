@extends('themes.default.layouts')

@section('header')
    <title>{{ $book->bookname }}_{{ systemConfig('title','Enda Blog') }} -Powered By  {{ systemConfig('subheading','Enda Blog') }}</title>
    <meta name="keywords" content="{{ $book->bookname }},{{ systemConfig('seo_key') }}" />
    <meta name="description" content="{!! str_limit(preg_replace('/\s/', '',strip_tags(conversionMarkdown($book->content))),100) !!}">
@endsection

@section('content')
    <section class="banner">
        <div class="collection-head">
            <div class="container">
                <div class="collection-title">
                    <h1 class="collection-header">{{ $book->bookname }}</h1>
                    <div class="collection-info">
                        <span class="meta-info">
                            <span class="octicon octicon-calendar"></span> {{ $book->created_at->format('Y-m-d') }}
                        </span>
                    </div>
                    <div class="collection-info">
                        <span class="meta-info">
                            {{ strCut(conversionMarkdown($book->content),40) }}
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- /.banner -->
    <section class="container content">
        <div class="columns">
            <div class="column three-fourths">
                <article class="article-content markdown-body">
                    {!! conversionMarkdown($book->content) !!}
                </article>
                <div class="share">
                    <div class="share-bar"></div>
                </div>
                <div class="comment">
                    <div class="comments">
                        <div id="disqus_thread"></div>
                        <script type="text/javascript">
                            var disqus_shortname = "{{ config('disqus.disqus_shortname') }}";
                            (function() {
                                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                                dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                            })();
                        </script>
                        <noscript>Please enable JavaScript to view the &lt;a href="http://disqus.com/?ref_noscript"&gt;comments powered by Disqus.&lt;/a&gt;</noscript>
                    </div>
                </div>
            </div>

            <div class="column one-fourth">
                <div id="author" class="clearfix">
                    <a href="{{ url(route('about.show',['id'=>$book->user->id])) }}" title="{{ $book->user->name }}">
                        <img class="img-circle" src="{{ asset('uploads'.'/'.$book->user->photo) }}" height="96" width="96" alt="{{ $book->user->name }}" title="{{ $book->user->name }}">
                    </a>
                    <div class="author-info">
                        <h3>
                            <a href="{{ url(route('about.show',['id'=>$book->user->id])) }}" title="{{ $book->user->name }}">
                                {{ $book->user->name }}
                            </a>
                        </h3>
                        <p>
                            {!! strip_tags(conversionMarkdown($book->user->desc)) !!}
                        </p>
                    </div>
                </div>
                @include('themes.default.right')
            </div>
        </div>
    </section>
@endsection