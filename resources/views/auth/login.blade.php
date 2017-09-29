@extends('layouts.app')

@section('title', 'Login')

@section('content')
    {{ Form::open(['url' => 'login']) }}
    <div class="form-group row">
        <h1>Login</h1>
        <div class="col-md-12 field">
            {{ $errors->first('email') }}
            {{ $errors->first('password') }}
        </div>
        <div class="col-md-6 field">
            {{ Form::label('email', 'Email Address') }}
            {{ Form::text('email', old('email'), ['class' => 'form-control']) }}
        </div>
        <div class="col-md-6 field">
            {{ Form::label('password', 'Password') }}
            {{ Form::password('password',['class' => 'form-control']) }}
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 field">
            {{ Form::submit('Login') }}
        </div>
    </div>
    {{ Form::close() }}
@endsection