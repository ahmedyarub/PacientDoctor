@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <h1>{{__('Profile')}}</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br/>
    @endif
    {{ Form::open(array("action" => "ProfileController@update_profile")) }}

    {{ Form::label('name', __('Name'), array('class'=>'control-label')) }}
    {{ Form::text('name', $profile->name) }}
    <br/>
    {{ Form::label('phone', __('Phone'), array('class'=>'control-label')) }}
    {{ Form::text('phone', $profile->phone) }}
    <br/>
    @if(\Auth::user()->isDoctor())
        {{ Form::label('address', __('Address'), array('class'=>'control-label')) }}
        {{ Form::text('address', $profile->address) }}
        <br/>
        {{ Form::label('specialization', __('Specialization'), array('class'=>'control-label')) }}
        {{ Form::text('specialization', $profile->specialization) }}
        <br/>
    @else
        {{ Form::label('genre', __('Genre'), array('class'=>'control-label')) }}
        {{ Form::text('genre', $profile->genre) }}
        <br/>
        {{ Form::label('city', __('City'), array('class'=>'control-label')) }}
        {{ Form::text('city', $profile->city) }}
        <br/>
        {{ Form::label('state', __('State'), array('class'=>'control-label')) }}
        {{ Form::text('state', $profile->state) }}
        <br/>
    @endif
    {{ Form::label('email', __('Email'), array('class'=>'control-label')) }}
    {{ Form::text('email', $profile->email, ['id'=> 'email1', 'readonly']) }}
    <br/>

    {{ Form::submit(__('Save'), array('class' => 'btn btn-default')) }}

    {{ Form::close() }}
@endsection