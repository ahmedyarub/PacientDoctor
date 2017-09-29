@extends('layouts.app')

@section('title', 'Answers List')

@section('content')
    <h1>{{__('Answers')}}</h1>
    <table>
        <tr>
            <th>{{ __("Answer")}}</th>
            <th>{{ __("Question")}}</th>
            <th colspan="2">{{ __("Actions")}}</th>
        </tr>

        @foreach ($answers as $answer)
            <tr>
                <td>{{$answer->answer}}</td>
                <td>{{$answer->question}}</td>
                <td><a href='edit/{{$answer->id}}'>{{ __('Edit')}}</a></td>
                <td><a href='delete/{{$answer->id}}'>{{ __('Delete')}}</a></td>
            </tr>
        @endforeach

    </table>
@endsection