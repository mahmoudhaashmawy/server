@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate.'partials.breadcrumb')

    <!-- blog details section start -->
    <section class="pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-details-area">
                        <div class="blog-details-thumb">
                            <img
                                src="{{ getImage('assets/images/frontend/blog/' . @$blog->data_values->image, '992x662') }}"
                                alt="image" class="w-100 rounded-3">
                        </div>
                        <div class="blog-details-content">
                            <ul class="post-meta mb-1">
                                <li>
                                    <i class="las la-eye"></i> {{ $blog->views }}
                                </li>
                                <li>
                                    <i class="lar la-calendar-alt"></i> {{ showDateTime($blog->created_at) }}
                                </li>
                            </ul>
                            <h3 class="blog-details-title">{{ __(@$blog->data_values->title) }}</h3>

                            @php echo @$blog->data_values->description @endphp

                        </div>
                    </div>
                    <div class="comment-form-area">
                        <div class="fb-comments" data-href="{{ route('blog.details',[$blog->id,slug($blog->data_values->title)]) }}" data-numposts="5"></div>
                    </div><!-- comment-form-area end -->
                </div>
                <div class="col-lg-4">
                    <div class="sidebar">
                        <div class="widget">
                            <h5 class="widget__title">@lang('Recent Posts')</h5>
                            <ul class="small-post-list">

                                @forelse($recent_posts as $item)
                                    <li class="small-post">
                                        <div class="small-post__thumb"><img src="{{ getImage('assets/images/frontend/blog/' . @$item->data_values->image, '58x36') }}" alt="image">
                                        </div>
                                        <div class="small-post__content">
                                            <h5 class="post__title"><a href="{{ route('blog.details',[$item->id,slug($item->data_values->title)]) }}">{{ __(@$item->data_values->title) }}</a></h5>
                                        </div>
                                    </li><!-- small-post end -->
                                @empty
                                    @lang('No More Post!')
                                @endforelse

                            </ul><!-- small-post-list end -->
                        </div><!-- widget end -->
                    </div><!-- sidebar end -->
                </div>
            </div>
        </div>
    </section>
    <!-- blog details section end -->
@endsection

@push('fbComment')
    @php echo loadFbComment() @endphp
@endpush
