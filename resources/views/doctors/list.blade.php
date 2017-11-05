@extends('layouts.app')

@section('title', 'Doctors List')

@section('content')
    <h1>{{__('Doctors')}}</h1>
    <table>
        <tr>
            <th>{{ __("Name")}}</th>
            <th>{{ __("Email")}}</th>
            <th>{{ __("Phone")}}</th>
            <th colspan="2">{{ __("Actions")}}</th>
        </tr>

    @foreach ($doctors as $doctor)
        <tr>
            <td>{{$doctor->name}}</td>
            <td>{{$doctor->email}}</td>
            <td>{{$doctor->phone}}</td>
            <td><a href='edit/{{$doctor->id}}'>{{ __('Edit')}}</a></td>
            <td><a href='delete/{{$doctor->id}}'>{{ __('Delete')}}</a></td>
        </tr>
    @endforeach

    </table>
@endsection
