@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate.'partials.breadcrumb')

    <!-- blog details section start -->
    <section class="pt-100 pb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="blog-details-area">
                        <div class="blog-details-content">

                            @php echo @$link->data_values->details @endphp

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- blog details section end -->
@endsection
