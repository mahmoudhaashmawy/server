@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.seminars.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">@lang('Name')</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                           value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">@lang('Category')</label>
                                    <select class="form-control" id="category" name="category_id" required="">
                                        <option value="">-- @lang('Select One') --</option>
                                        @forelse($categories as $item)
                                            <option value="{{ $item->id }}">{{ __(@$item->name) }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="location">@lang('Location')</label>
                                    <input type="text" id="location" class="form-control" value="{{ old('location') }}"
                                           autocomplete="off" name="location" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="map_latitude">@lang('Map Latitude')</label>
                                    <input type="text" id="map_latitude" class="form-control" value="{{ old('map_latitude') }}"
                                           autocomplete="off" placeholder="@lang('Ex') 23.8103" name="map_latitude" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="map_longitude">@lang('Map Longitude')</label>
                                    <input type="text" id="map_longitude" class="form-control" value="{{ old('map_longitude') }}"
                                           autocomplete="off" placeholder="@lang('Ex') 90.4125" name="map_longitude" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="duration">@lang('Duration')</label>
                                    <input type="text" id="duration" class="form-control" value="{{ old('duration') }}"
                                           autocomplete="off" name="duration" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start_time">@lang('Start Time')</label>
                                    <input type="text" class="form-control timepicker" id="departure_time" value="{{ old('start_time') }}"
                                           autocomplete="off" name="start_time" required="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="end_time">@lang('End Time')</label>
                                    <input type="text" class="form-control timepicker" id="return_time" value="{{ old('end_time') }}"
                                           autocomplete="off" name="end_time" required="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="capacity">@lang('Capacity')</label>
                                    <input type="text" class="form-control" id="capacity" value="{{ old('capacity') }}"
                                           autocomplete="off" name="capacity" required="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="price">@lang('Price')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="price" name="price"
                                               value="{{ old('price') }}" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">{{ $general->cur_text }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('What Includes')</label>
                                    <small class="ml-2 mt-2 text-facebook">@lang('Separate multiple by') <code>,</code>(comma)
                                        or <code>enter</code> key</small>
                                    <!-- Multiple select-2 with tokenize -->
                                    <select class="select2-auto-tokenize" name="included[]" multiple="multiple">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('What Excludes')</label>
                                    <small class="ml-2 mt-2 text-facebook">@lang('Separate multiple by') <code>,</code>(comma)
                                        or <code>enter</code> key</small>
                                    <!-- Multiple select-2 with tokenize -->
                                    <select class="select2-auto-tokenize" name="excluded[]" multiple="multiple">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nicEditor0">@lang('Details')</label>
                                    <textarea rows="10" name="details" class="form-control nicEdit"
                                              id="nicEditor0">{{ old('details') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card border--dark mb-4">
                                    <div class="card-header bg--dark d-flex justify-content-between">
                                        <h5 class="text-white">@lang('Images')</h5>
                                        <button type="button" class="btn btn-sm btn-outline-light addBtn"><i
                                                class="fa fa-fw fa-plus"></i>@lang('Add New')
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <p><small class="text-facebook">@lang('Images will be resize into')
                                                {{ imagePath()['seminars']['size'] }}px</small></p>
                                        <div class="row element">

                                            <div class="col-md-2 imageItem">
                                                <div class="payment-method-item">
                                                    <div class="payment-method-header d-flex flex-wrap">
                                                        <div class="thumb" style="position: relative;">
                                                            <div class="avatar-preview">
                                                                <div class="profilePicPreview"
                                                                     style="background-image: url('{{asset('assets/images/default.png')}}')">

                                                                </div>
                                                            </div>
                                                            <div class="avatar-edit">
                                                                <input type="file" name="images[]"
                                                                       class="profilePicUpload" id="0"
                                                                       accept=".png, .jpg, .jpeg" required>
                                                                <label for="0" class="bg-primary">
                                                                    <i class="la la-pencil"></i>
                                                                </label>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="card border--dark">
                                    <h5 class="card-header bg--dark">@lang('Seminar Plan')
                                        <button type="button"
                                                class="btn btn-sm btn-outline-light float-right addNewInformation">
                                            <i class="la la-fw la-plus"></i>@lang('Add New')
                                        </button>
                                    </h5>

                                    <div class="card-body">
                                        <div class="row addedField">


                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn--primary w-100">@lang('Create')</button>
                    </div>
                </form>
            </div><!-- card end -->
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <a href="{{ route('admin.seminars.index') }}" class="btn btn-sm btn--primary box--shadow1 text-white text--small"><i
            class="fa fa-fw fa-backward"></i>@lang('Go Back')</a>
@endpush

@push('script-lib')
    <script src="{{asset('assets/admin/js/vendor/datepicker.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/vendor/datepicker.en.js')}}"></script>
@endpush
@push('style')
    <style>
        .avatar-remove {
            position: absolute;
            bottom: 180px;
            right: 0;
        }

        .avatar-remove label {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            font-size: 15px;
            cursor: pointer;
        }
    </style>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
            // js for Multiple select-2 with tokenize
            $(".select2-auto-tokenize").select2({
                tags: true,
                tokenSeparators: [',']
            });

            // Date time picker
            var start = new Date(),
                prevDay,
                startHours = 12;

            // 12:00 AM
            start.setHours(12);
            start.setMinutes(0);

            // If today is Saturday or Sunday set 10:00 AM
            if ([6, 0].indexOf(start.getDay()) != -1) {
                start.setHours(12);
                startHours = 12
            }
            // date and time picker
            $('.timepicker').datepicker({
                timepicker: true,
                language: 'en',
                dateFormat: 'yyyy-mm-dd',
                startDate: start,
                minHours: startHours,
                maxHours: 24,
                onSelect: function (fd, d, picker) {
                    // Do nothing if selection was cleared
                    if (!d) return;

                    var day = d.getDay();

                    // Trigger only if date is changed
                    if (prevDay != undefined && prevDay == day) return;
                    prevDay = day;

                    // If chosen day is Saturday or Sunday when set
                    // hour value for weekends, else restore defaults
                    if (day == 6 || day == 0) {
                        picker.update({
                            minHours: 24,
                            maxHours: 24
                        })
                    } else {
                        picker.update({
                            minHours: 24,
                            maxHours: 24
                        })
                    }
                }
            });

            var counter = 0;
            $('.addBtn').click(function () {
                counter++;
                $('.element').append(`<div class="col-md-2 imageItem"><div class="payment-method-item"><div class="payment-method-header d-flex flex-wrap"><div class="thumb" style="position: relative;"><div class="avatar-preview"><div class="profilePicPreview" style="background-image: url('{{asset('assets/images/default.png')}}')"></div></div><div class="avatar-edit"><input type="file" name="images[]" class="profilePicUpload" required id="image${counter}" accept=".png, .jpg, .jpeg" /><label for="image${counter}" class="bg-primary"><i class="la la-pencil"></i></label></div>
                <div class="avatar-remove">
                    <label class="bg-danger removeBtn">
                        <i class="la la-close"></i>
                    </label>
                </div>
                </div></div></div></div>`);
                remove()
                upload()
            });

            function scrol() {
                var bottom = $(document).height() - $(window).height();
                $('html, body').animate({
                    scrollTop: bottom
                }, 200);
            }

            function remove() {
                $('.removeBtn').on('click', function () {
                    $(this).parents('.imageItem').remove();
                });
            }

            function upload() {
                function proPicURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var preview = $(input).parents('.thumb').find('.profilePicPreview');
                            $(preview).css('background-image', 'url(' + e.target.result + ')');
                            $(preview).addClass('has-image');
                            $(preview).hide();
                            $(preview).fadeIn(65);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }

                $(".profilePicUpload").on('change', function () {
                    proPicURL(this);
                });

                $(".remove-image").on('click', function () {
                    $(this).parents(".profilePicPreview").css('background-image', 'none');
                    $(this).parents(".profilePicPreview").removeClass('has-image');
                    $(this).parents(".thumb").find('input[type=file]').val('');
                });
            }

            //----- Add Information fields-------//
            $('.addNewInformation').on('click', function () {
                var html = `
                <div class="col-md-12 other-info-data">
                    <div class="form-group">
                        <div class="input-group mb-md-0 mb-4">
                            <div class="col-md-2">
                                <input name="title[]" class="form-control" type="text" required placeholder="@lang('Title')">
                            </div>
                            <div class="col-md-3">
                                <input name="subtitle[]" class="form-control" type="text" required placeholder="@lang('Subtitle')">
                            </div>
                            <div class="col-md-6 mt-md-0 mt-2">
                                <textarea name="content[]" class="form-control" required placeholder="@lang('Content')"></textarea>
                            </div>
                            <div class="col-md-1 mt-md-0 mt-2 text-right">
                                <span class="input-group-btn">
                                    <button class="btn btn--danger btn-lg removeInfoBtn w-100" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>`;

                $('.addedField').append(html);
            });

            $(document).on('click', '.removeInfoBtn', function () {
                $(this).closest('.other-info-data').remove();
            });


            $('select[name=category_id]').val('{{old('category_id')}}');

        })(jQuery);
    </script>
@endpush
