@extends('layouts.app')

@section('title', 'Pacients List')

@section('content')
    <h1>{{__('Pacients')}}</h1>
    <table>
        <tr>
            <th>@lang("Name")</th>
            <th>{{ __("Genre")}}</th>
            <th>{{ __("Birth")}}</th>
            <th>{{ __("Email")}}</th>
            <th>{{ __("Phone")}}</th>
            <th colspan="2">{{ __("Actions")}}</th>
        </tr>
        @foreach ($pacients as $pacient)
            <tr>
                    <td>{{$pacient->name}}</td>
                    <td>{{$pacient->genre}}</td>
                    <td>{{$pacient->email}}</td>
                    <td>{{$pacient->phone}}</td>
                    <td><a href='edit/{{$pacient->id}}'>{{ __('Edit')}}</a></td>
                    <td><a href='delete/{{$pacient->id}}'>{{ __('Delete')}}</a></td>
                  </tr>



        @endforeach
    </table>
@endsection