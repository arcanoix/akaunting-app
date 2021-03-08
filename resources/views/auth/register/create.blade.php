@extends('layouts.auth')

@section('title', trans('auth.register'))

@section('message', trans('auth.register_to'))

@section('content')
<div role="alert" class="alert alert-danger d-none" :class="(form.response.error) ? 'show' : ''" v-if="form.response.error" v-html="form.response.message"></div>


{!! Form::open([
    'route' => 'register',
    'id' => 'register',
    '@submit.prevent' => 'onSubmit',
    '@keydown' => 'form.errors.clear($event.target.name)',
    'files' => true,
    'role' => 'form',
    'class' => 'form-loading-button',
    'novalidate' => true
]) !!}

    {{ Form::textGroup('company_name', null, 'building', ['required' => 'required', 'placeholder' => trans('install.settings.company_name')], old('company_name'), 'col-md-12') }}

    {{ Form::textGroup('company_email', null, 'envelope', ['required' => 'required', 'placeholder' => trans('install.settings.company_email')], old('company_email'), 'col-md-12') }}

    {{ Form::textGroup('user_email', null, 'envelope', ['required' => 'required', 'placeholder' => trans('install.settings.admin_email')], old('user_email'), 'col-md-12') }}

    {{ Form::passwordGroup('user_password', null, 'key', ['required' => 'required', 'placeholder' => trans('install.settings.admin_password')], 'col-md-12 mb-2') }}

    <div class="mt-5">
        <div class="float-right">
            <div class="col-xs-12 col-sm-4">
                {!! Form::button(
                '<div class="aka-loader"></div> <span>' . trans('auth.register') . '</span>',
                [':disabled' => 'form.loading', 'type' => 'submit', 'class' => 'btn btn-success float-right', 'data-loading-text' => trans('general.loading')]) !!}
            </div>
        </div>
    </div>

{!! Form::close() !!}

@endsection

@push('scripts_start')
    <script src="{{ asset('public/js/auth/register.js?v=' . version('short')) }}"></script>
@endpush


