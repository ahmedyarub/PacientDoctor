@extends('layouts.app')

@section('title', 'Categories List')

@section('content')
    <h1>{{__('Select a Doctor')}}</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br/>
    @endif
    {{ Form::open(["action" => "DoubtsController@saveDoubt"]) }}

    {{ Form::hidden('doubt_id', $doubt_id) }}

    {{ Form::label('doctor', __('Doctor'), array('class'=>'control-label')) }}
    {{ Form::select('doctor', $doctors, null) }}
    <br/>
    {{ Form::submit(__('Save'), array('class' => 'btn btn-default')) }}
    {{ Form::close() }}

@endsection