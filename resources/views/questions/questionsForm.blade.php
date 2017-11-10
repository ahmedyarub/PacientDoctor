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
    {{ Form::label('choices', __('With choices?'), array('class'=>'control-label')) }}
    {{ Form::checkbox('choices',null,true) }}
    <br/>
    {{ Form::label('text', __('With text?'), array('class'=>'control-label')) }}
    {{ Form::checkbox('text',null,true) }}
    <br/>
    {{ Form::submit(__('Save'), array('class' => 'btn btn-default')) }}
    {{ Form::close() }}
@endsection