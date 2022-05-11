@php
    $blog_content = getContent('blog.content', true);
    $blog_elements = getContent('blog.element', false, 3);
@endphp
<!-- blog section start -->
<section class="pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-header">
                    <h2 class="section-title">{{ __(@$blog_content->data_values->heading) }}</h2>
                </div>
            </div>
        </div><!-- row end -->
        <div class="row gy-4 justify-content-center">

            @forelse($blog_elements as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="post-card wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">
                        <div class="post-card__thumb">
                            <a href="{{ route('blog.details', [$item->id, slug($item->data_values->title)]) }}" class="w-100 h-100"><img src="{{ getImage('assets/images/frontend/blog/thumb_' . @$item->data_values->image, '626x387') }}" alt="image"></a>
                        </div>
                        <div class="post-card__content">
                            <ul class="post-card__meta mb-1">
                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="las la-calendar"></i>
                                        <span>{{ showDateTime($item->created_at) }}</span>
                                    </a>
                                </li>
                            </ul>
                            <h5 class="post-card__title"><a href="{{ route('blog.details', [$item->id, slug($item->data_values->title)]) }}">{{ __(@$item->data_values->title) }}</a></h5>
                            <p class="mt-4">{{ __(@$item->data_values->short_description) }}</p>
                            <a href="{{ route('blog.details', [$item->id, slug($item->data_values->title)]) }}" class="text--btn text-decoration-underline mt-3">@lang('Read More')</a>
                        </div>
                    </div><!-- post-card end -->
                </div>
            @empty
            @endforelse

        </div>
    </div>
</section>
<!-- blog section end -->
