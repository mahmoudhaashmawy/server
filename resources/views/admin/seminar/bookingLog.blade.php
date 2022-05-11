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
                                <th scope="col">@lang('Seminar')</th>
                                <th scope="col">@lang('Seat - Price')</th>
                                <th scope="col">@lang('TRX')</th>
                                <th scope="col">@lang('Start Time')</th>
                                <th scope="col">@lang('Status')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($seminar_logs as $log)
                                <tr>
                                    <td data-label="@lang('User')">
                                        <span class="font-weight-bold">{{ $log->user->fullname }}</span>
                                        <br>
                                        <span class="small"> <a href="{{ route('admin.users.detail', $log->user_id) }}"><span>@</span>{{ $log->user->username }}</a> </span>
                                    </td>

                                    <td data-label="@lang('Seminar')">{{ __($log->seminar->name) }}</td>
                                    <td data-label="@lang('Seat - Price')">{{ $log->seat }} <br> 
                                        <strong>{{ $general->cur_sym }}{{ __(showAmount($log->price)) }}</strong>
                                    </td>
                                    <td data-label="@lang('TRX')">{{ __($log->trx) }}</td>
                                    <td data-label="@lang('Start Time')">
                                        {{ showDateTime($log->seminar->start_time) }}<br>{{ diffForHumans($log->seminar->start_time) }}
                                    </td>
                                    
                                    <td data-label="@lang('Status')">
                                        @if($log->seminar->start_time < now())
                                            <span class="text--small badge font-weight-normal badge--success">@lang('Completed')</span>                                            
                                        @else
                                            <span class="text--small badge font-weight-normal badge--warning">@lang('Running')</span>
                                        @endif
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
                    {{ $seminar_logs->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>
    </div>
@endsection