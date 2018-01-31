@extends('layouts.app')

@section('title', 'Waiting Patients List')

@section('content')
    <style>
        .wrapper {
            width: 100%;
            overflow: hidden; /* will contain if #first is longer than #second */
            border: 1px solid black;
        }

        .first {
            width: 50%;
            float: left; /* add this */
            border: 1px solid black;
        }

        .second {
            overflow: hidden; /* if you don't want #second to wrap below #first */
            border: 1px solid black;
        }
    </style>
    <h1>{{__('Waiting Patients')}}</h1>
    {{Form::open(["action" => "QueueController@nextPatient"])}}
    {{Form::label('cases_count','Cases in queue: ',['id' => 'cases_count'])}}
    <br>
    {{Form::button('Next Case',['id' => 'next_case'])}}
    {{Form::close()}}
    <div id="call_section" class="hidden">
        <div class="wrapper">
            <div class="first">
                <div>Your Video</div>
                <video id="localVideo" autoplay muted></video>
            </div>

            <div class="second">
                <div id="remote_video_label">Patient's Video</div>
                <video id="remoteVideo" autoplay></video>
            </div>
        </div>

        <button id="call" onclick="call()">Call</button>

        <div class="wrapper">
            <div class="first">
                @if(\Auth::user()->isDoctor())
                    <br>
                    {{Form::textarea('message',null,['id'=>'message'])}}
                    <br>
                    {{Form::button('Send Message',['id' => 'send_message'])}}
                @endif
                <div>Journal</div>
                <textarea id="notes" style="width:100%"></textarea>
                <button id="submit_notes" onclick="submit_notes()">Save Journal</button>
            </div>

            <div class="second">
                <div id="case_data" class="hidden">
                    <div id="questions_answers_section">

                    </div>
                    <div id="image_section">
                        <img id="image" src="" style="max-height:500px;">
                    </div>
                </div>
            </div>
        </div>

        <button onclick="end_call()" class="hidden" id="end_call">End Call</button>

        <button onclick="toggle_configuration()" id="configuration">Configuration</button>

        <div class="hidden" id="configuration_section">
            <div>Please select an audio output:</div>
            <select type="select" id="audio_source"></select>

            <div>Please select an video output:</div>
            <select type="select" id="video_source"></select>
        </div>
    </div>

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

    <script>
        var ringtone_path = '{{asset('ringtone.mp3')}}';
        var myAudio;
        var cases_count = 0;
        var case_id = null;

        function playAudio(path) {
            myAudio = new Audio(path);
            myAudio.addEventListener('ended', function () {
                this.currentTime = 0;
                this.play();
            }, false);
            myAudio.play();
        }

        function update_cases() {
            $.get(public_path + '/doctors/waiting_patients',
                {}, function (data) {
                    if (data.status == 0) {
                        if (cases_count != data.cases_count) {
                            cases_count = data.cases_count;

                            $('#cases_count').text('Cases in queue: ' + cases_count);

                            alert('Cases updated!');
                        }
                    }
                }, "json");

            setTimeout(update_cases, 5000);
        }

        function toggle_configuration() {
            $('#configuration_section').toggleClass('hidden');
        }

        function end_call() {
            hangup();
        }

        function submit_notes() {
            event.preventDefault();

            $.post(public_path + '/queue/submit_notes', {
                case_id: case_id,
                notes: $("#notes").val()
            }, function (data) {
                alert('Journal saved successfully!');
            });
        }

        function send_result() {
            $.post(public_path + '/queue/submit_case_result', {
                case_id: case_id,
                case_result: $("#case_result").val(),
                other_notes: $("#other_notes").val()
            }, function (data) {
                $('#case_result_section').addClass('hidden');

                alert('Call result submitted!');
            });
        }

        function call() {
            $('#end_call').removeClass('hidden');
            $('#call').addClass('hidden');
            $('#next_case').addClass('hidden');

            start_call(case_id);
        }

        $(document).ready(function () {
            @if(!\Auth::user()->isDoctor())
            $('#remote_video_label').text("Doctor's Video")
            @endif

            $("#audio_source").change(setAudioOutput);

            $("#video_source").change(function () {
                video_device_id = $('#video_source').val();
            });

            $('#next_case').click(function(even){
                $('#case_data').addClass('hidden');
                $('#call_section').addClass('hidden');

                $.get(public_path + '/queue/next_patient',
                    {
                    }, function (data) {
                        if (data.status == 0) {
                            case_id = data.case_id;

                            var case_text = '';

                            $('#questions_answers_section').html(data.question_answer);

                            $('#image').attr('src', data.image);

                            $('#case_data').removeClass('hidden');
                            $('#call_section').removeClass('hidden');
                        } else {
                            alert('No more cases!');
                        }
                    }, "json");
            });

            $('#send_message').click(function (event) {
                event.preventDefault();

                $.post(public_path + '/doctors/send_message',
                    {
                        case_id: case_id,
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
