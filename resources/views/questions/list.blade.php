@extends('layouts.app')

@section('title', 'Questions List')

@section('content')
    <h1>{{__('Questions')}}</h1>
    {{ Html::linkAction('QuestionsController@form','New') }}
    <table>
        <tr>
            <th>{{ __("Question")}}</th>
            <th>{{ __("Category")}}</th>
            <th colspan="2">{{ __("Actions")}}</th>
        </tr>

        @foreach ($questions as $question)
            <tr>
                <td>{{$question->question}}</td>
                <td>{{$question->category}}</td>
                <td><a href='edit/{{$question->id}}'>{{ __('Edit')}}</a></td>
                <td><a href='delete/{{$question->id}}'>{{ __('Delete')}}</a></td>
            </tr>
        @endforeach

    </table>
@endsection