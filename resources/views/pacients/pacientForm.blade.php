@extends('layouts.app')
    <h1>{{__('Add a Pacient')}}</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
    @endif
        {{ Form::open(array("action" => "PacientsController@addPacient")) }}
            {{ Form::label('name', __('Name'), array('class'=>'control-label')) }}
            {{ Form::text('name') }}
    <br />
            {{ Form::label('address', __('Address'), array('class'=>'control-label')) }}
            {{ Form::text('address') }}
    <br />
            {{ Form::label('birth', __('Birth'), array('class'=>'control-label')) }}
            {{ Form::text('birth','', array('id'=> 'birth')) }}
    <br />
            {{ Form::label('phone', __('Phone'), array('class'=>'control-label')) }}
            {{ Form::text('phone', '', array('id'=> 'phone')) }}
    <br />
            {{ Form::label('email', __('Email'), array('class'=>'control-label')) }}
            {{ Form::text('email','', array('id'=> 'email')) }}
    <br />
            {{ Form::label('password', __('Password'), array('class'=>'control-label')) }}
            {{ Form::password('password') }}
    <br />
            {{ Form::label('genre', __('Genre'), array('class'=>'control-label')) }}
            {{ Form::text('genre') }}
    <br />
            {{ Form::submit(__('Save'), array('class' => 'btn btn-default')) }}
        {{ Form::close() }}
    </body>
</html>