@extends('layouts.app')

@section('title', 'Doctors List')

@section('content')
    <h1>{{__('Cases')}}</h1>
    {{Form::open(["action" => "DoctorsController@send_message"])}}
    {{Form::select('case_id',$cases,null,['id' => 'case_id', 'placeholder' => 'Please select a case to be viewed'])}}
    @if(\Auth::user()->isDoctor())
        {{Form::text('message')}}
        {{Form::submit('Send Message')}}
    @endif
    {{Form::close()}}
    <div id="case_data" class="hidden">
        <div id="questions_answers_section">

        </div>
        <div id="image_section">
            <img id="image" src="">
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#case_id").change(function () {
                $('#case_data').addClass('hidden');
                $('#call_section').addClass('hidden');

                $.get(public_path + '/queue/case_data',
                    {
                        case_id: $("#case_id").val()
                    }, function (data) {
                        if (data.status == 0) {
                            var case_text = '';

                            $('#questions_answers_section').html(data.question_answer);

                            $('#image').attr('src', data.image);

                            $('#case_data').removeClass('hidden');
                        } else {
                            alert('Error getting case data!');
                        }
                    }, "json");
            });
        });
    </script>
@endsection
