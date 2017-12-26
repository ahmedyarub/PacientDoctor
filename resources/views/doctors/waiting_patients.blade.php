@extends('layouts.app')

@section('title', 'Waiting Patients List')

@section('content')
    <h1>{{__('Cases')}}</h1>
    {{Form::open(["action" => "QueueController@nextPatient"])}}
    {{Form::select('case_id',$cases,null,['id' => 'case_id', 'placeholder' => 'Select a case to view its data'])}}
    {{Form::close()}}
    <div id="call_section" class="hidden">
        <button onclick="hangup()" class="hidden" id="end_call">End Call</button>

        <div>Please select an audio output:</div>
        <select type="select" id="audio_source"></select>

        <div>Please select an video output:</div>
        <select type="select" id="video_source"></select>

        <div>Remote Video</div>
        <video id="remoteVideo" autoplay></video>

        <div>Local Video</div>
        <video id="localVideo" autoplay muted></video>

        <button id="call" onclick="call()">Call</button>

        <div>Notes</div>
        <textarea id="notes" style="width:100%"></textarea>
        <button id="submit_notes" onclick="submit_notes()">Submit Notes</button>

        <div id="case_result_section" class="hidden">
            <div>Were you able to help the patient?</div>
            <select id="case_result">
                <option value="yes">Yes</option>
                <option value="no">No</option>
                <option value="other">other</option>
            </select>
            <textarea id="other_notes" style="width:100%"></textarea>
            <button onclick="send_result()">Send Result</button>
        </div>
    </div>
    <div id="case_data" class="hidden">
        <div id="questions_answers_section">

        </div>
        <div id="image_section">
            <img id="image" src="">
        </div>
    </div>
    <script>
        function update_cases() {
            $.get(public_path + '/doctors/waiting_patients',
                {}, function (data) {
                    if (data.status == 0) {
                        if ($('#case_id option').size() - 1 != data.cases.length) {
                            $('#case_id').find('option').not(':first').remove();

                            $.each(data.cases, function (index) {
                                $('#case_id').append(new Option(data.cases[index].name, data.cases[index].id));
                            });

                            alert('Cases updated!');
                        }
                    }
                }, "json");

            setTimeout(update_cases, 5000);
        }

        function hangup(event) {
            event.preventDefault();

            $('#end_call').addClass('hidden');
            hangup();

            $.post('/queue/finish_call', {case_id: $("#case_id").val()}, function (data) {
                $('#case_result_section').removeClass('hidden');

                alert('Call finished!');
            });
        }

        function submit_notes() {
            $.post('/queue/submit_notes', {
                case_id: $("#case_id").val(),
                notes: $("#notes").val()
            }, function (data) {
                $('#case_result_section').addClass('hidden');
                $('#call_section').addClass('hidden');

                alert('Notes submitted!');
            });
        }

        function send_result() {
            $.post('/queue/submit_case_result', {
                case_id: $("#case_id").val(),
                case_result: $("#case_result").val(),
                other_notes: $("#other_notes").val()
            }, function (data) {
                $('#case_result_section').addClass('hidden');
                $('#call_section').addClass('hidden');

                alert('Call result submitted!');
            });
        }

        function call() {
            $('#end_call').removeClass('hidden');
            $('#call').removeClass('hidden');
            start_call($("#case_id").val());
        }

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
                            $('#call_section').removeClass('hidden');
                        } else {
                            alert('Error getting case data!');
                        }
                    }, "json");
            });

            setTimeout(update_cases, 5000);
        });
    </script>
    <script src="{{asset('js/doctors/waiting_patients.js')}}"></script>
    <script src="{{asset('js/call/call.js')}}"></script>
@endsection
