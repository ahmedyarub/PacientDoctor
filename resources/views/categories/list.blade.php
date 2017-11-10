@extends('layouts.app')

@section('title', 'Categories List')

@section('content')
    <h1>{{__('Categories')}}</h1>
    <table>
        <tr>
            <th>{{ __("Category")}}</th>
            <th colspan="2">{{ __("Actions")}}</th>
        </tr>
        {{ Html::linkAction('CategoriesController@form','New') }}
        @foreach ($categories as $category)
            <tr>
                <td>{{$category->category}}</td>
                <td><a href='edit/{{$category->id}}'>{{ __('Edit')}}</a></td>
                <td><a href='delete/{{$category->id}}'>{{ __('Delete')}}</a></td>
            </tr>
        @endforeach

    </table>
@endsection