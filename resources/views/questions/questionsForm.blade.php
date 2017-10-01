@extends('layouts.app')

@section('title', 'Question Registration')

@section('content')
    <h1>{{__('Add a Question')}}</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br/>
    @endif
    {{ Form::open(array("action" => "QuestionsController@addQuestion")) }}

    {{ Form::label('category', __('Category'), array('class'=>'control-label')) }}
    {{ Form::select('category', $categories) }}
    <br/>
    {{ Form::label('question', __('Question'), array('class'=>'control-label')) }}
    {{ Form::text('question') }}
    <br/>
    {{ Form::submit(__('Save'), array('class' => 'btn btn-default')) }}
    {{ Form::close() }}
@endsection