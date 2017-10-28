@extends('layouts.app')

@section('title', 'Categories List')

@section('content')
    <h1>{{__('Categories')}}</h1>
    <table>
        <tr>
            <th>{{ __("Category")}}</th>
            <th colspan="2">{{ __("Actions")}}</th>
        </tr>

        <p>
            Queue Count:<br>
            {{$queue_count}}
            @if($queue_count==0)
                {{ Form::open(["action" => "QueueController@startCall"]) }}
                {{ Form::hidden('case_id', $case_id) }}
                {{Form::submit('Start Call')}}
                {{ Form::close() }}
            @endif
        </p>
    </table>
@endsection