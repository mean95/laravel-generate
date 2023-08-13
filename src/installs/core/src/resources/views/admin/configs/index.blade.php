@extends('core::admin.layouts.app')
@push('link')

@endpush
@section('breadcrumb')
    @include('core::admin.layouts.breadcrumb', [
        'module' => 'Configs',
    ])
@stop

@section('content')
    <section class="content">
        {{
            Form::open([
                'action' => 'ConfigController@store',
                'route' => getPrefix() . '.configs.store',
                'id' => 'validate_form_configs'
            ])
        }}
        <div class="row">
            <div class="col-md-9">
                <div class="row flexbox-section">
                    <div class="col-md-4">
                        <div class="section-title pl-4 pt-4">
                            <h5>{{ trans('core::admin.label.general_information') }}</h5>
                        </div>
                        <div class="section-description pl-4">
                            <p class="color-note">{{ trans('core::admin.warning.setting_site_information') }}</p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="admin_email">{{ trans('core::admin.label.email_admin') }}</label>
                                    <input type="email" class="form-control" autocomplete="off" value="{{ getConfig('email_admin') }}" name="admin_email" placeholder="your-email@gmail.com">
                                </div>
                                <div class="form-group">
                                    <label for="time_zone">{{ trans('core::admin.label.time_zone') }}</label>
                                    <select class="form-control select2" name="time_zone" style="width: 100%;">
                                        <option value="0">None</option>
                                        @php
                                            $TZ = getConfig('time_zone')
                                        @endphp
                                        @foreach ($timeZones as $timezone)
                                            <option value="{{ $timezone['zone'] }}"
                                                    @if($TZ === $timezone['zone']) selected @endif>{{ $timezone['diff_from_GMT'] . ' - ' . $timezone['zone'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="site_title">{{ trans('core::admin.label.site_title') }}</label>
                                    <input type="text" class="form-control" autocomplete="off" value="{{ getConfig('site_title') }}" name="site_title" id="site_title" placeholder="{{ trans('core::admin.placeholder.site_title') }}" />
                                </div>
                                <div class="form-group">
                                    <label for="seo_title">{{ trans('core::admin.label.seo_title') }}</label>
                                    <input type="text" class="form-control" autocomplete="off" value="{{ getConfig('seo_title') }}" name="seo_title" id="seo_title" placeholder="{{ trans('core::admin.placeholder.seo_title') }}" />
                                </div>
                                <div class="form-group">
                                    <label for="seo_description">{{ trans('core::admin.label.seo_description') }}</label>
                                    <textarea type="text" cols="30" rows="4" class="form-control" autocomplete="off" name="seo_description" id="seo_description" placeholder="{{ trans('core::admin.placeholder.seo_description') }}"
                                    >{{ getConfig('seo_description') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="site_description">{{ trans('core::admin.label.site_description') }}</label>
                                    <input type="text" class="form-control" autocomplete="off" value="{{ getConfig('site_description') }}" name="site_description" id="site_description" placeholder="{{ trans('core::admin.placeholder.site_description') }}" />
                                </div>
                                <div class="form-group">
                                    <label for="address">{{ trans('core::admin.label.address') }}</label>
                                    <input type="text" class="form-control" autocomplete="off" value="{{ getConfig('address') }}" name="address" id="address" placeholder="{{ trans('core::admin.placeholder.address') }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row flexbox-section">
                    <div class="col-md-4">
                        <div class="section-title pl-4 pt-4">
                            <h5>{{ trans('core::admin.label.logo') }}</h5>
                        </div>
                        <div class="section-description pl-4">
                            <p class="color-note">{{ trans('core::admin.warning.setting_logo') }}</p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group group-file">
                                    <label for="theme_logo">{{ trans('core::admin.label.theme_logo') }}</label>
                                    <div class="custom-file">
                                        {{ Form::text('theme_logo', old('theme_logo', getConfig('theme_logo'))) }}
                                        <label class="custom-file-label" for="customFile">
                                            {{ getUrlFile(getConfig('theme_logo')) ?: trans('core::admin.button.choose_file') }}
                                        </label>
                                    </div>
                                    <div class="file-preview" style="margin-top:15px">
                                        @if(!empty(getConfig('theme_logo')))
                                            <img src="{{ getUrlFileThumbnail(getConfig('theme_logo')) }}"/>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group group-file">
                                    <label for="theme_favicon">{{ trans('core::admin.label.theme_favicon') }}</label>
                                    <div class="custom-file">
                                        {{ Form::text('theme_favicon', old('theme_favicon', getConfig('theme_favicon'))) }}
                                        <label class="custom-file-label" for="customFile">
                                            {{ getUrlFile(getConfig('theme_favicon')) ?: trans('core::admin.button.choose_file') }}
                                        </label>
                                    </div>
                                    <div class="file-preview" style="margin-top:15px">
                                        @if(!empty(getConfig('theme_favicon')))
                                            <img src="{{ getUrlFileThumbnail(getConfig('theme_favicon')) }}"/>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row flexbox-section">
                    <div class="col-md-4">
                        <div class="section-title pl-4 pt-4">
                            <h5>{{ trans('core::admin.label.social') }}</h5>
                        </div>
                        <div class="section-description pl-4">
                            <p class="color-note">{{ trans('core::admin.warning.setting_social') }}</p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="facebook">{{ trans('core::admin.label.facebook') }}</label>
                                    <input type="text" class="form-control" autocomplete="off" value="{{ getConfig('facebook') }}" name="facebook" id="facebook" placeholder="{{ trans('core::admin.placeholder.facebook') }}" />
                                </div>
                                <div class="form-group">
                                    <label for="twitter">{{ trans('core::admin.label.twitter') }}</label>
                                    <input type="text" class="form-control" autocomplete="off" value="{{ getConfig('twitter') }}" name="twitter" id="twitter" placeholder="{{ trans('core::admin.placeholder.twitter') }}" />
                                </div>
                                <div class="form-group">
                                    <label for="instagram">{{ trans('core::admin.label.instagram') }}</label>
                                    <input type="text" class="form-control" autocomplete="off" value="{{ getConfig('instagram') }}" name="instagram" id="instagram" placeholder="{{ trans('core::admin.placeholder.instagram') }}" />
                                </div>
                                <div class="form-group">
                                    <label for="youtube">{{ trans('core::admin.label.youtube') }}</label>
                                    <input type="text" class="form-control" autocomplete="off" value="{{ getConfig('youtube') }}" name="youtube" id="youtube" placeholder="{{ trans('core::admin.placeholder.youtube') }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            &#12644;
                        </h3>
                    </div>
                    <div class="card-body">
                        @include('core::admin.common.buttons.save')
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </section>
@stop
@push('script')

@endpush