@extends('layouts.admin')

@section('title', trans('general.title.new', ['type' => trans_choice('general.companies', 1)]))

@section('content')
    <div class="card">
        {!! Form::open([
            'id' => 'company',
            'route' => 'companies.store',
            '@submit.prevent' => 'onSubmit',
            '@keydown' => 'form.errors.clear($event.target.name)',
            'files' => true,
            'role' => 'form',
            'class' => 'form-loading-button',
            'novalidate' => true
        ]) !!}

            <div class="card-body">
                <div class="row">
                    {{ Form::textGroup('name', trans('general.name'), 'font') }}

                    {{ Form::emailGroup('email', trans('general.email'), 'envelope') }}

                    {{ Form::selectGroup('currency', trans_choice('general.currencies', 1), 'exchange-alt', $currencies) }}

                    {{ Form::selectGroup('locale', trans_choice('general.languages', 1), 'flag', language()->allowed(), setting('default.locale', config('app.locale', 'en-GB')), []) }}

                    {{ Form::textGroup('tax_number', trans('general.tax_number'), 'percent', [], setting('company.tax_number')) }}

                    {{ Form::textGroup('phone', trans('settings.company.phone'), 'phone', [], setting('company.phone')) }}

                    {{ Form::textGroup('address', trans('general.address')) }}
                    {{ Form::textGroup('street',  trans('general.street')) }}
                    {{ Form::textGroup('no_int',  trans('general.no_int')) }}
                    {{ Form::textGroup('state',   trans('general.state')) }}
                    {{ Form::textGroup('colony', trans('general.colony')) }}
                    {{ Form::textGroup('reference', trans('general.reference')) }}
                    {{ Form::textGroup('no_ext', trans('general.no_ext')) }}
                    {{ Form::textGroup('zone_code', trans('general.zone_code')) }}
                    {{ Form::textGroup('municipality', trans('general.municipality')) }}
                    {{ Form::textGroup('location', trans('general.location')) }}
                    {{ Form::textGroup('country', trans('general.country')) }}
                    {{ Form::textGroup('curp', trans('general.curp')) }}

                    {{ Form::fileGroup('logo', trans('companies.logo'), '', ['dropzone-class' => 'form-file']) }}

                    {{ Form::fileGroup('certificate', trans('companies.certificate'), '', ['dropzone-class' => 'form-file', 'options' => ['acceptedFiles' => '.cer']]) }}

                    {{ Form::fileGroup('key_private', trans('companies.key_private'), '', ['dropzone-class' => 'form-file', 'options' => ['acceptedFiles' => '.key']]) }}

                    {{ Form::radioGroup('enabled', trans('general.enabled'), true) }}
                </div>
            </div>

            <div class="card-footer">
                <div class="row save-buttons">
                    {{ Form::saveButtons('companies.index') }}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection

@push('scripts_start')
    <script src="{{ asset('public/js/common/companies.js?v=' . version('short')) }}"></script>
@endpush
