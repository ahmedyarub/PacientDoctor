@extends('layouts.app')

@section('title', 'Waiting Patients List')

@section('content')
    <style>
        #wrapper {
            width: 100%;
            overflow: hidden; /* will contain if #first is longer than #second */
        }

        #first {
            width: 50%;
            float: left; /* add this */
        }

        #second {
            overflow: hidden; /* if you don't want #second to wrap below #first */
        }
    </style>
    <h1>{{__('Waiting Patients')}}</h1>
    {{Form::open(["action" => "QueueController@nextPatient"])}}
    {{Form::select('case_id',$cases,null,['id' => 'case_id', 'placeholder' => 'Select a case to view its data', 'size' => 5])}}
    {{Form::close()}}
    <div id="call_section" class="hidden">
        <div id="wrapper">
            <div id="first">
                <div>Local Video</div>
                <video id="localVideo" autoplay muted></video>
            </div>

            <div id="second">
                <div>Remote Video</div>
                <video id="remoteVideo" autoplay></video>
            </div>
        </div>

        <button onclick="end_call()" class="hidden" id="end_call">End Call</button>
        <button id="call" onclick="call()">Call</button>

        <div>Notes</div>
        <textarea id="notes" style="width:100%"></textarea>
        <button id="submit_notes" onclick="submit_notes()">Save Notes</button>
        @if(\Auth::user()->isDoctor())
            <br>
            {{Form::textarea('message',null,['id'=>'message'])}}
            <br>
            {{Form::button('Send Message',['id' => 'send_message'])}}
        @endif
        <div>Please select an audio output:</div>
        <select type="select" id="audio_source"></select>

        <div>Please select an video output:</div>
        <select type="select" id="video_source"></select>


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

        function end_call() {
            hangup();
        }

        function submit_notes() {
            event.preventDefault();

            $.post(public_path + '/queue/submit_notes', {
                case_id: $("#case_id").val(),
                notes: $("#notes").val()
            }, function (data) {
                alert('Notes saved successfully!');
            });
        }

        function send_result() {
            $.post(public_path + '/queue/submit_case_result', {
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
            $('#call').addClass('hidden');
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

            $("#audio_source").change(setAudioOutput);

            $("#video_source").change(function () {
                video_device_id = $('#video_source').val();
            });

            $('#send_message').click(function (event) {
                event.preventDefault();

                $.post(public_path + '/doctors/send_message',
                    {
                        case_id: $("#case_id").val(),
                        message: $("#message").val()
                    },
                    function (data) {
                        alert('Message sent successfully!');
                    });
            });

            navigator.mediaDevices.enumerateDevices()
                .then(function (deviceInfos) {
                    for (var i = 0; i !== deviceInfos.length; ++i) {
                        var deviceInfo = deviceInfos[i];

                        if (deviceInfo.kind === 'audiooutput') {
                            $('#audio_source').append(new Option(deviceInfo.label, deviceInfo.deviceId));
                        } else if (deviceInfo.kind === 'videoinput') {
                            $('#video_source').append(new Option(deviceInfo.label, deviceInfo.deviceId));
                        }
                    }
                });

            setTimeout(update_cases, 5000);
        });
    </script>
    <script src="{{asset('js/doctors/waiting_patients.js')}}"></script>
    <script src="{{asset('js/call/call.js')}}"></script>
@endsection
