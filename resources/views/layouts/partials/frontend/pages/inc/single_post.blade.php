@extends('layouts.app')

@section('title', isset($pageTitle) ? $pageTitle : 'Welcome to Blog')

@section('meta_tags')
    <meta name="robots" content="index,follow, max-snippet:-1, max-large-preview:large, max-video-preview:-1" />
    <meta name="title" content="{{ Str::ucfirst($post->post_title) }}" />
    <meta name="description" content="{{ Str::ucfirst(words($post->post_content, 120)) }}" />
    <meta name="author" content="{{ Str::ucfirst($post->author->username) }}" />
    <link rel="canonical" href="{{ route('read_post', $post->post_slug) }}" />
    <meta property="og:title" content="{{ Str::ucfirst($post->post_title) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:description" content="{{ Str::ucfirst(words($post->post_content, 120)) }}" />
    <meta property="og:url" content="{{ route('read_post', $post->post_slug) }}" />
    <meta property="og:image" content="{{ asset('/storage/uploads/posts/thumbnails/resized_' . $post->featured_image) }}" />
    <meta name="twitter:domain" content="{{ Request::getHost() }}" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="{{ Str::ucfirst($post->post_title) }}" />
    <meta name="twitter:description" content="{{ Str::ucfirst(words($post->post_content, 120)) }}" />
    <meta name="twitter:image"
        content="{{ asset('/storage/uploads/posts/thumbnails/resized_' . $post->featured_image) }}" />
@endsection

@section('content')
    <section class="section">
        <div class="container">
            <article class="row mb-4">
                <div class="col-lg-10 mx-auto mb-4">
                    <h1 class="h2 mb-3">
                        {{ $post->post_title }}
                    </h1>
                    <ul class="list-inline post-meta mb-3">
                        <li class="list-inline-item">
                            <i class="ti-user mr-2"></i><a
                                href="author.html">{{ $post->author->where('id', $post->author_id)->pluck('username')->first() }}</a>
                        </li>
                        <li class="list-inline-item"><i class="ti-calendar"></i> : {{ date_formatter($post->created_at) }}
                        </li>
                        <li class="list-inline-item">
                            Categories : <a href="{{ route('category_posts', $post->subcategory->slug) }}"
                                class="ml-1">{{ $post->subcategory->parentCategory->category_name }} </a>
                        </li>
                        @if ($post->post_tags)
                            <li class="list-inline-item">
                                Tags <i class="ti-tag"></i> :
                                @php
                                    $postTagsString = $post->post_tags;
                                    $tagsArray = explode(',', $postTagsString);
                                @endphp
                                @foreach ($tagsArray as $tag)
                                    <a href="{{ route('tag_posts', $tag) }}">#{{$tag}}</a>
                                @endforeach
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="col-12 mb-3">
                    <div class="post-slider">
                        <img src="{{ asset('/storage/uploads/posts/' . $post->featured_image) }}" class="img-fluid"
                            alt="post-thumb" />
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <div class="content">
                                <h5 class="paragraph"></h5>
                                <p>{!! $post->post_content !!}</p>
                            </div>
                        </div>
                        <div class="col-md-4 mx-auto">
                            <!-- categories -->
                            <div class="widget">
                                <h5 class="widget-title"><span>Categories</span></h5>
                                @if (categories())
                                    @foreach (categories() as $category)
                                        <ul class="list-unstyled widget-list">
                                            <li>
                                                <a href="{{ route('category_posts', $category->slug) }}" class="d-flex">
                                                    {{ Str::ucfirst($category->subcategory_name) }}
                                                    <small class="ml-auto">({{ $category->posts->count() }})</small>
                                                </a>
                                            </li>
                                        </ul>
                                    @endforeach
                                @else
                                    <ul class="list-unstyled widget-list">
                                        <li>
                                            <a href="#!" class="d-flex">There No Categories..!</a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                            <!-- latest articles -->
                            <div class="widget">
                                <h5 class="widget-title"><span>Latest Articles</span></h5>
                                <!-- post-item -->
                                @foreach (latest_sidebar_posts($post->id) as $item)
                                    <ul class="list-unstyled widget-list">
                                        <li class="media widget-post align-items-center">
                                            <a href="{{ route('read_post', $item->post_slug) }}">
                                                <img loading="lazy" class="mr-3"
                                                    src="{{ asset('/storage/uploads/posts/thumbnails/thumb_' . $item->featured_image) }}">
                                            </a>
                                            <div class="media-body">
                                                <h5 class="h6 mb-0">
                                                    <a
                                                        href="{{ route('read_post', $item->post_slug) }}">{{ $item->post_title }}</a>
                                                </h5>
                                                <small>{{ date_formatter($post->created_at) }}</small>
                                            </div>
                                        </li>
                                    </ul>
                                @endforeach
                            </div>
                            <!-- tags -->
                            @if (tags_posts())
                                @php
                                    $postTagsString = tags_posts();
                                    $tagsArray = array_unique(explode(',', $postTagsString));
                                @endphp
                                <div class="widget">
                                    <h5 class="widget-title"><span>Tags</span></h5>
                                    <ul class="list-inline widget-list-inline">
                                        @foreach ($tagsArray as $tag)
                                            <li class="list-inline-item">
                                                <a href="{{ route('tag_posts', $tag) }}"
                                                    class="tags">#{{ $tag }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if (count($related_posts) > 0)
                    <div class="col-lg-12 col-md-6">
                        <div class="widget">
                            <h5 class="widget-title"><span>Related Posts</span></h5>
                            <!-- post-item -->
                            @foreach ($related_posts as $item)
                                <div class="col-lg-6 col-md-4">
                                    <ul class="list-unstyled widget-list">
                                        <li class="media widget-post align-items-center">
                                            <a href="{{ route('read_post', $item->post_slug) }}">
                                                <img loading="lazy" class="mr-3"
                                                    src="{{ asset('/storage/uploads/posts/thumbnails/thumb_' . $item->featured_image) }}"
                                                    alt="Post Thumbnail">
                                            </a>
                                            <div class="media-body">
                                                <h5 class="h6 mb-0">
                                                    <a href="{{ route('read_post', $item->post_slug) }}">
                                                        {{ $item->post_title }}
                                                    </a>
                                                </h5>
                                                <p class="post_content mb-0">
                                                    {{ Str::ucfirst(words($item->post_content, 25)) }}</p>
                                                <small>{{ date_formatter($post->created_at) }}</small>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="col-lg-10 max-auto mb-3">
                    <div id="disqus_thread"></div>
                    <script>
                        /**
                         *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                         *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */

                        var disqus_config = function() {
                            this.page.url =
                                "{{ route('read_post', $post->post_slug) }}"; // Replace PAGE_URL with your page's canonical URL variable
                            this.page.identifier =
                                "{{ $post->id }}"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                        };

                        (function() { // DON'T EDIT BELOW THIS LINE
                            var d = document,
                                s = d.createElement('script');
                            s.src = 'https://blog-site-xtdusv51du.disqus.com/embed.js';
                            s.setAttribute('data-timestamp', +new Date());
                            (d.head || d.body).appendChild(s);
                        })();
                    </script>
                    <noscript>
                        Please enable JavaScript to view the
                        <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a>
                    </noscript>
                </div>
            </article>
        </div>
    </section>
@endsection


@push('stylesheets')
    <link rel="stylesheet" href="/share_buttons/jquery.floating-social-share.min.css" />
@endpush

@push('scripts')
    <script src="/share_buttons/jquery.floating-social-share.min.js"></script>
    <script>
        $("body").floatingSocialShare({
            buttons: [
                "facebook",
                "twitter",
                "linkedin",
                "pinterest",
                "reddit",
                "whatsapp",
                "reddit",
                "telegram"
            ],
            text: "share with:",
            url: "{{ route('read_post', $post->post_slug) }}"
        });
    </script>
@endpush
