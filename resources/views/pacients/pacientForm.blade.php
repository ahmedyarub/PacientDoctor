@extends('layouts.app')

@section('title', 'Doctor Registration')

@section('content')
    <h1>{{__('Add a Pacient')}}</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br/>
    @endif
    {{ Form::open(array("action" => "PacientsController@addPacient")) }}
    {{ Form::label('name', __('Name'), array('class'=>'control-label')) }}
    {{ Form::text('name') }}
    <br/>
    {{ Form::label('city', __('City'), array('class'=>'control-label')) }}
    {{ Form::text('city') }}
    <br/>
    {{ Form::label('state', __('State'), array('class'=>'control-label')) }}
    {{ Form::text('state','', array('id'=> 'state')) }}
    <br/>
    {{ Form::label('phone', __('Phone'), array('class'=>'control-label')) }}
    {{ Form::text('phone', '', array('id'=> 'phone')) }}
    <br/>
    {{ Form::label('genre', __('Genre'), array('class'=>'control-label')) }}
    {{ Form::text('genre') }}
    <br/>
    {{ Form::label('email', __('Email'), array('class'=>'control-label')) }}
    {{ Form::text('email','', array('id'=> 'email')) }}
    <br/>
    {{ Form::label('password', __('Password'), array('class'=>'control-label')) }}
    {{ Form::password('password') }}
    <br/>
    {{ Form::submit(__('Save'), array('class' => 'btn btn-default')) }}
    {{ Form::close() }}
@endsection