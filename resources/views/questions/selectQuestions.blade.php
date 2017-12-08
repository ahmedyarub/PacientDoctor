@extends('layouts.app')

@section('title', 'Questions List')

@section('content')
    <h1>{{__('Select Questions')}}</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br/>
    @endif
    {{ Form::open(["action" => "QuestionsController@selectDoctor", 'files' => true]) }}
    {{ Form::hidden('category_id', $category) }}

    @foreach($questions as $question)
        {{ $question->question }}
        <br/>
        @if($question->choices)
            {{ Form::select('answers['.$question->id.']', $question->answers)}}
        @endif

        @if($question->text)
            {{ Form::Input('text','written_answers['.$question->id.']', null)}}
        @endif
        <br/>

    @endforeach

    <br/>

    {{ Form::file('image') }}

    {{ Form::submit(__('Save'), array('class' => 'btn btn-default')) }}

    {{ Form::close() }}

@endsection