@extends('layouts.app')

@section('title', 'Categories List')

@section('content')
    <h1>{{__('Select a Category')}}</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br/>
    @endif
    {{ Form::open(["action" => "QuestionsController@selectQuestions"]) }}

    {{ Form::label('category', __('Category'), array('class'=>'control-label')) }}
    {{ Form::select('category', $categories, null) }}
    <br/>
    {{ Form::submit(__('Save'), array('class' => 'btn btn-default')) }}
    {{ Form::close() }}

@endsection