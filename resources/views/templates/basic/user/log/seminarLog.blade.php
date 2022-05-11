@extends($activeTemplate.'layouts.master')

@section('content')
<section class="pt-100 pb-100">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-12">
          <div class="custom--card">
            <div class="table-responsive--md">
              <table class="table custom--table">
                <thead>
                  <tr>
                    <th>@lang('Seminar')</th>
                    <th>@lang('Seat')</th>
                    <th>@lang('Price')</th>
                    <th>@lang('Ticket ID')</th>
                    <th>@lang('Start Time')</th>
                    <th>@lang('End Time')</th>
                    <th>@lang('Status')</th>
                  </tr>
                </thead>
                <tbody>

                  @forelse ($seminar_logs as $log)
                  <tr>
                    <td data-label="@lang('Seminar')">
                      <div class="table-tour-single  justify-content-lg-start justify-content-end">
                        <div class="thumb"><img src="{{ getImage(imagePath()['seminars']['path'].'/'.@$log->seminar->images[0], '57x37') }}" alt="img"></div>
                        <div class="content">
                          <h6 class="fs--16px"><a href="{{ route('seminar.details', [$log->plan_id, slug($log->seminar->name)]) }}">{{ __(@$log->seminar->name) }}</a></h6>
                        </div>
                      </div>
                    </td>
                    <td data-label="@lang('Seat')">{{ $log->seat }}</td>
                    <td data-label="@lang('Price')"><strong>{{ $general->cur_sym }}{{ __(showAmount($log->price)) }}</strong></td>
                    <td data-label="@lang('Ticket ID')">#{{ __($log->trx) }}</td>
                    <td data-label="@lang('Start Time')">
                      {{ showDateTime($log->seminar->start_time) }}<br>{{ diffForHumans($log->seminar->start_time) }}
                    </td>
                    <td data-label="@lang('End Time')">
                      {{ showDateTime($log->seminar->end_time) }}<br>{{ diffForHumans($log->seminar->end_time) }}
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
                      
                  @endforelse
                  
                </tbody>
              </table>
            </div>
          </div>
          <nav class="mt-5">
            {{$seminar_logs->links()}}
          </nav>
        </div>
      </div>
    </div>
  </section>
@endsection
