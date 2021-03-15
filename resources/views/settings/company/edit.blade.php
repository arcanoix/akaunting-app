@extends('layouts.admin')

@section('title', trans_choice('general.companies', 1))

@section('content')
    {!! Form::open([
        'id' => 'setting',
        'method' => 'PATCH',
        'route' => 'settings.update',
        '@submit.prevent' => 'onSubmit',
        '@keydown' => 'form.errors.clear($event.target.name)',
        'files' => true,
        'role' => 'form',
        'class' => 'form-loading-button',
        'novalidate' => true
    ]) !!}

    <div class="card">
        <div class="card-body">
            <div class="row">
                {{ Form::textGroup('name', trans('settings.company.name'), 'building', ['required' => 'required'], setting('company.name')) }}

                {{ Form::textGroup('email', trans('settings.company.email'), 'envelope', ['required' => 'required'], setting('company.email')) }}

                {{ Form::textGroup('tax_number', trans('general.tax_number'), 'percent', [], setting('company.tax_number')) }}

                {{ Form::textGroup('phone', trans('settings.company.phone'), 'phone', [], setting('company.phone')) }}

                {{ Form::textGroup('address', trans('settings.company.address'), 'address', [], setting('company.address')) }}

                {{ Form::textGroup('street',  trans('general.street'), '', [], setting('company.street')) }}
                {{ Form::textGroup('no_int',  trans('general.no_int'), '', [], setting('company.no_int')) }}
                {{ Form::textGroup('state',   trans('general.state'), '', [], setting('company.state')) }}
                {{ Form::textGroup('colony', trans('general.colony'), '', [], setting('company.colony')) }}
                {{ Form::textGroup('reference', trans('general.reference'), '', [], setting('company.reference')) }}
                {{ Form::textGroup('no_ext', trans('general.no_ext'), '', [], setting('company.no_ext')) }}
                {{ Form::textGroup('zone_code', trans('general.zone_code'), '', [], setting('company.zone_code')) }}
                {{ Form::textGroup('municipality', trans('general.municipality'), '', [], setting('company.municipality')) }}
                {{ Form::textGroup('location', trans('general.location'), '', [], setting('company.location')) }}
                {{ Form::textGroup('country', trans('general.country'), '', [], setting('company.country')) }}

                {{ Form::fileGroup('certificate', trans('companies.certificate'), '', ['dropzone-class' => 'form-file', 'options' => ['acceptedFiles' => '.cer']]) }}

                {{ Form::fileGroup('key_private', trans('companies.key_private'), '', ['dropzone-class' => 'form-file', 'options' => ['acceptedFiles' => '.key']]) }}

                {{ Form::fileGroup('logo', trans('settings.company.logo'), 'file-image-o', [], setting('company.logo')) }}

            </div>
        </div>

        @can('update-settings-settings')
            <div class="card-footer">
                <div class="row save-buttons">
                    {{ Form::saveButtons('settings.index') }}
                </div>
            </div>
        @endcan
    </div>

    {!! Form::hidden('_prefix', 'company') !!}

    {!! Form::close() !!}
@endsection

@push('scripts_start')
    <script src="{{ asset('public/js/settings/settings.js?v=' . version('short')) }}"></script>
@endpush
