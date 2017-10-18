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
    {{ Form::open(["action" => "QuestionsController@selectDoctor"]) }}
    {{ Form::hidden('category_id', $category) }}

    @foreach($questions as $question)

        {{ $question->question }}


            <br />
            {{ Form::select('answers['.$question->id.']', $question->answers)}}
            {{ Form::Input('text','written_answers['.$question->id.']', null)}}

        <br />

    @endforeach

    <br/>
    {{ Form::submit(__('Save'), array('class' => 'btn btn-default')) }}
    {{ Form::close() }}

@endsection