@extends($activeTemplate.'layouts.master')

@section('content')
    <div class="container pt-50 pb-50">
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="custom--card">
                    <div class="table-responsive--md">
                            <table class="table custom--table">
                                <thead>
                                <tr>
                                    <th>@lang('Subject')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Priority')</th>
                                    <th>@lang('Last Reply')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($supports as $key => $support)
                                    <tr>
                                        <td data-label="@lang('Subject')"> <a href="{{ route('ticket.view', $support->ticket) }}" class="font-weight-bold"> [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                                        <td data-label="@lang('Status')">
                                            @if($support->status == 0)
                                                <span class="badge badge--success py-2 px-3">@lang('Open')</span>
                                            @elseif($support->status == 1)
                                                <span class="badge badge--primary py-2 px-3">@lang('Answered')</span>
                                            @elseif($support->status == 2)
                                                <span class="badge badge--warning py-2 px-3">@lang('Customer Reply')</span>
                                            @elseif($support->status == 3)
                                                <span class="badge badge--dark py-2 px-3">@lang('Closed')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Priority')">
                                            @if($support->priority == 1)
                                                <span class="badge badge--dark py-2 px-3">@lang('Low')</span>
                                            @elseif($support->priority == 2)
                                                <span class="badge badge--success py-2 px-3">@lang('Medium')</span>
                                            @elseif($support->priority == 3)
                                                <span class="badge badge--primary py-2 px-3">@lang('High')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Last Reply')">{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>

                                        <td data-label="@lang('Action')">
                                            <a href="{{ route('ticket.view', $support->ticket) }}" class="btn btn--base btn-sm">
                                                <i class="fa fa-desktop"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                </div>
                {{$supports->links()}}
            </div>
        </div>
    </div>
@endsection
