@extends('layouts.app')

@section('title', 'Doctors List')

@section('content')
    <h1>{{__('Cases')}}</h1>
    {{Form::open(["action" => "DoctorsController@send_message"])}}
    {{Form::select('case_id',$cases,null,['id' => 'case_id'])}}
    {{Form::text('message')}}
    {{Form::submit('Send Message')}}
    {{Form::close()}}
@endsection
