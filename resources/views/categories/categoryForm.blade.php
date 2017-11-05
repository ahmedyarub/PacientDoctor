@extends('layouts.app')

@section('title', 'Include Category')

@section('content')
    <h1>{{Lang::get('Add a Category')}}</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br/>
    @endif
    {{ Form::open(array("action" => "CategoriesController@addCategory")) }}
    {{ Form::label('category', Lang::get('Name'), array('class'=>'control-label')) }}
    {{ Form::text('category') }}
    <br/>
    {{ Form::submit(Lang::get('Save'), array('class' => 'btn btn-default')) }}
    {{ Form::close() }}
@endsection