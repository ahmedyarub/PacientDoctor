@extends('layouts.app')

@section('title', 'Login')

@section('content')
    {{ Form::open(['url' => 'login']) }}
    <h1>Login</h1>
    <p>
        {{ $errors->first('email') }}
        {{ $errors->first('password') }}
    </p>
    <p>
        {{ Form::label('email', 'Email Address') }}
        {{ Form::text('email', old('email'), array('placeholder' => '')) }}
    </p>
    <p>
        {{ Form::label('password', 'Password') }}
        {{ Form::password('password') }}
    </p>
    <p>{{ Form::submit('Submit!') }}</p>
    {{ Form::close() }}
@endsection