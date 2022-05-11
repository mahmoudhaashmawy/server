@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light tabstyle--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('User')</th>
                                <th scope="col">@lang('Plan')</th>
                                <th scope="col">@lang('Rating')</th>
                                <th scope="col">@lang('Comment')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($ratings as $rating)
                                <tr>
                                    <td data-label="@lang('User')">
                                        <span class="font-weight-bold">{{ $rating->user->fullname }}</span>
                                        <br>
                                        <span class="small"> <a href="{{ route('admin.users.detail', $rating->user_id) }}"><span>@</span>{{ $rating->user->username }}</a> </span>
                                    </td>
                                    <td data-label="@lang('Plan')">
                                        @if($rating->type == 'tour')
                                            <span class="text--small badge font-weight-normal badge--success">@lang('Tour')</span><br>
                                            {{ $rating->plan->name }}
                                        @else
                                            <span class="text--small badge font-weight-normal badge--primary">@lang('Seminar')</span><br>
                                            {{ $rating->seminar->name }}
                                        @endif
                                    </td>
                                    <td data-label="@lang('Rating')">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($rating->rating >= $i)
                                            <i class="las la-star"></i>
                                            @else
                                            <i class="lar la-star"></i>
                                            @endif
                                        @endfor
                                    </td>

                                    <td data-label="@lang('Comment')">
                                        @if ($rating->comment)
                                        <a href="javascript:void(0)" class="icon-btn commentBtn" data-original-title="@lang('Comment')" data-toggle="tooltip" data-comment="@php echo $rating->comment @endphp">
                                            <i class="la la-eye"></i>
                                        </a>
                                        @endif
                                    </td>

                                    <td data-label="@lang('Action')">
                                        <a href="javascript:void(0)" class="icon-btn btn--danger deleteBtn" data-original-title="@lang('Action')" data-toggle="tooltip" data-url="{{ route('admin.ratings.delete', $rating->id) }}">
                                            <i class="la la-trash"></i>
                                        </a>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer">
                    {{ $ratings->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>
    </div>



    {{-- Comment MODAL --}}
    <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('Comment')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body ratingComment">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Status MODAL --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('Delete')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form method="post" action="">
                    @csrf

                    <div class="modal-body">
                        <p class="text-muted">@lang('Are you sure to delete?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--danger deleteButton">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($){
            "use strict";

            //Comment
            $('.commentBtn').on('click', function () {
                var modal = $('#commentModal');
                var comment = $(this).data('comment');

                $('.ratingComment').html(comment);
                modal.modal('show');
            });

            //Delete
            $('.deleteBtn').on('click', function () {
                var modal = $('#deleteModal');
                var url = $(this).data('url');

                modal.find('form').attr('action', url);
                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush
