var video_devices = [];
var audio_devices = [];
var audio_device_id;
var video_device_id;

var call_status = 'Pending';

var isChannelReady = false;
var isInitiator = false;
var isStarted = false;
var localStream;
var pc;
var remoteStream;
var turnReady;
var pcConfig = {
    iceTransportPolicy: "relay",
    'iceServers': [{
        'url': 'turn:fam-doc.com:5349',
        credential: 'test',
        username: 'test'
    }]
};

var sdpConstraints = {
    offerToReceiveAudio: true,
    offerToReceiveVideo: true
};
var socket = io.connect('https://fam-doc.com:8780/');
var constraints = {
    audio: true,
    video: true
};
var ringtone;

var iceCandidates;

$(document).ready(function () {
    navigator.mediaDevices.enumerateDevices()
        .then(function (deviceInfos) {
            for (var i = 0; i !== deviceInfos.length; ++i) {
                var deviceInfo = deviceInfos[i];

                if (deviceInfo.kind === 'audiooutput') {
                    audio_devices.push({
                        id: deviceInfo.deviceId,
                        label: deviceInfo.label || ('Audio ' + (i + 1))
                    });
                } else if (deviceInfo.kind === 'videoinput') {
                    video_devices.push({
                        id: deviceInfo.deviceId,
                        label: deviceInfo.label || ('Video ' + (i + 1))
                    });
                }
            }
        });

    getUserMedia();

    console.log('Getting user media with constraints', constraints);

    socket.on('created', function (room) {
        console.log('Created room ' + room);
    });

    socket.on('full', function (room) {
        console.log('Room ' + room + ' is full');
    });

    socket.on('join', function (room) {
        console.log('Another peer made a request to join room ' + room);
        console.log('This peer is the initiator of room ' + room + '!');
        isChannelReady = true;

        maybeStart();
    });

    socket.on('joined', function (room) {
        console.log('joined: ' + room);
        isChannelReady = true;
    });

    socket.on('log', function (array) {
        console.log.apply(console, array);
    });

    socket.on('message', function (message) {
        console.log('Client received message:', message);
        if (message === 'got user media') {
            //maybeStart();
        } else if (message.type === 'offer') {
            console.log('Call accepted');
            if (!isInitiator) {
                maybeStart();
            }

            console.log('Setting remote description');
            pc.setRemoteDescription(new RTCSessionDescription(message));

            for (var i = 0; i < iceCandidates.length; i++) {
                pc.addIceCandidate(iceCandidates[i]);
            }

            console.log('Sending answer to peer.');
            pc.createAnswer().then(
                function (sessionDescription) {
                    // Set Opus as the preferred codec in SDP if Opus is present.
                    //  sessionDescription.sdp = preferOpus(sessionDescription.sdp);
                    pc.setLocalDescription(sessionDescription);
                    console.log('setLocalAndSendMessage sending message', sessionDescription);
                    sendMessage(sessionDescription);
                }, function (error) {
                    console.log('Failed to create session description: ' + error.toString());
                }
            );
        } else if (message.type === 'answer') {
            pc.setRemoteDescription(new RTCSessionDescription(message));
        } else if (message.type === 'candidate') {
            var candidate = new RTCIceCandidate({
                sdpMLineIndex: message.label,
                candidate: message.candidate
            });
            if (isStarted) {
                console.log('Add candidates');
                pc.addIceCandidate(candidate);
            } else {
                console.log('Queue candidates');
                iceCandidates.push(candidate);
            }
        } else if (message === 'bye' && isStarted) {
            handleRemoteHangup();
        }
    });

//if (location.hostname !== 'localhost') {
    requestTurn(
        window.location.hostname === "localhost" ? '/stun/' : 'https://fam-doc.com:3478/'
    );
//}

    window.onbeforeunload = function () {
        sendMessage('bye');
    }
    ;

    if (document.URL.startsWith('file')) {
        ringtones.getRingtone().then(function (ringtones) {
            ringtone = ringtones[0].Url;
        })
        ;
    }
});

function initiate_call(case_id) {
    isInitiator = true;
    socket.emit('create or join', case_id);
    console.log('Attempted to create or  join room', case_id);
}

function start_call(case_id) {
    playAudio(ringtone_path);

    iceCandidates = new Array();
    socket.emit('create or join', case_id);
    console.log('Attempted to create or  join room', case_id);
}

function getUserMedia() {
    if (video_device_id)
        constraints.video = {deviceId: video_device_id};
    else
        constraints.video = true;


    navigator.mediaDevices.getUserMedia(constraints)
        .then(function (stream) {
            console.log('Adding local stream.');
            document.querySelector('#localVideo').setAttribute('src', window.URL.createObjectURL(stream));
            localStream = stream;
            sendMessage('got user media');
        })
}

function sendMessage(message) {
    console.log('Client sending message: ', message);
    socket.emit('message', message);
}

function maybeStart() {
    console.log('>>>>>>> maybeStart() ', isStarted, localStream, isChannelReady);
    if (!isStarted && typeof localStream !== 'undefined' && isChannelReady) {
        //if (typeof localStream !== 'undefined' && isChannelReady) {
        console.log('>>>>>> creating peer connection');
        createPeerConnection();
        pc.addStream(localStream);
        isStarted = true;
        console.log('isInitiator', isInitiator);
        if (isInitiator) {
            doCall();
        }
    }
}

function createPeerConnection() {
    try {
        pc = new webkitRTCPeerConnection(pcConfig);
        pc.oniceconnectionstatechange = function () {
            if (!pc)
                console.log('ICE state: Connection dropped');
            else
                console.log('ICE state: ', pc.iceConnectionState);
        }
        ;
        pc.onicecandidate = function (event) {
            console.log('icecandidate event: ', event);
            if (event.candidate) {
                socket.emit('message', {
                    type: 'candidate',
                    label: event.candidate.sdpMLineIndex,
                    id: event.candidate.sdpMid,
                    candidate: event.candidate.candidate
                });
            } else {
                console.log('End of candidates.');
            }
        }
        ;
        pc.onaddstream = function (event) {
            console.log('Remote stream added.');
            document.querySelector('#remoteVideo').setAttribute('src', window.URL.createObjectURL(event.stream));
            remoteStream = event.stream;

            call_status = 'In Progress';

            myAudio.stop();
        }
        ;

        pc.onremovestream = function (event) {
            console.log('Remote stream removed. Event: ', event);
        }
        ;
        console.log('Created RTCPeerConnnection');
    } catch (e) {
        console.log('Failed to create PeerConnection, exception: ' + e.message);
        alert('Cannot create RTCPeerConnection object.');
        return;
    }
}

function setAudioOutput() {
    var tmp = document.querySelector('#remoteVideo');
    tmp.setSinkId($('#audio_source').val());
}

function handleCreateOfferError(event) {
    console.log('createOffer() error: ', event);
}

function doCall() {
    console.log('Sending offer to peer');
    pc.createOffer(function (sessionDescription) {
            // Set Opus as the preferred codec in SDP if Opus is present.
            //  sessionDescription.sdp = preferOpus(sessionDescription.sdp);
            pc.setLocalDescription(sessionDescription);
            console.log('setLocalAndSendMessage sending message', sessionDescription);
            sendMessage(sessionDescription);
        },
        function (error) {
            console.log('Failed to create session description: ' + error.toString());
        }
    )
    ;
}

function requestTurn(turnURL) {
    var turnExists = false;
    for (var i in pcConfig.iceServers) {
        if (pcConfig.iceServers[i].url.substr(0, 5) === 'turn:') {
            turnExists = true;
            turnReady = true;
            break;
        }
    }
    if (!turnExists) {
        console.log('Getting TURN server from ', turnURL);
        // No TURN server. Get one from computeengineondemand.appspot.com:
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var turnServer = JSON.parse(xhr.responseText);
                console.log('Got TURN server: ', turnServer);
                pcConfig.iceServers.push({
                    'url': 'turn:' + turnServer.username + '@' + turnServer.turn,
                    'credential': turnServer.password
                });
                turnReady = true;
            }
        }
        ;
        xhr.open('GET', turnURL, true);
        xhr.send();
    }
}

function hangup() {
    console.log('Hanging up.');
    stop();
    sendMessage('bye');
}

function handleRemoteHangup() {
    console.log('Session terminated.');
    stop();
    isInitiator = false;
}

function stop() {
    call_status = 'Finished';
    isStarted = false;
    // isAudioMuted = false;
    // isVideoMuted = false;
    pc.close();
    pc = null;

    $('#end_call').addClass('hidden');
    $('#call_section').addClass('hidden');
    $('#call').removeClass('hidden');
    $('#next_case').removeClass('hidden');

    $.post(public_path + '/queue/finish_call', {case_id: case_id}, function (data) {
        $('#case_result_section').removeClass('hidden');

        alert('Call finished!');
    });
}

///////////////////////////////////////////

// Set Opus as the default audio codec if it's present.
function preferOpus(sdp) {
    var sdpLines = sdp.split('\r\n');
    var mLineIndex;
    // Search for m line.
    for (var i = 0; i < sdpLines.length; i++) {
        if (sdpLines[i].search('m=audio') !== -1) {
            mLineIndex = i;
            break;
        }
    }
    if (mLineIndex === null) {
        return sdp;
    }

    // If Opus is available, set it as the default in m line.
    for (i = 0; i < sdpLines.length; i++) {
        if (sdpLines[i].search('opus/48000') !== -1) {
            var opusPayload = extractSdp(sdpLines[i], /:(\d+) opus\/48000/i);
            if (opusPayload) {
                sdpLines[mLineIndex] = setDefaultCodec(sdpLines[mLineIndex],
                    opusPayload);
            }
            break;
        }
    }

    // Remove CN in m line and sdp.
    sdpLines = removeCN(sdpLines, mLineIndex);

    sdp = sdpLines.join('\r\n');
    return sdp;
}

function extractSdp(sdpLine, pattern) {
    var result = sdpLine.match(pattern);
    return result && result.length === 2 ? result[1] : null;
}

// Set the selected codec to the first in m line.
function setDefaultCodec(mLine, payload) {
    var elements = mLine.split(' ');
    var newLine = [];
    var index = 0;
    for (var i = 0; i < elements.length; i++) {
        if (index === 3) { // Format of media starts from the fourth.
            newLine[index++] = payload; // Put target payload to the first.
        }
        if (elements[i] !== payload) {
            newLine[index++] = elements[i];
        }
    }
    return newLine.join(' ');
}

// Strip CN from sdp before CN constraints is ready.
function removeCN(sdpLines, mLineIndex) {
    var mLineElements = sdpLines[mLineIndex].split(' ');
    // Scan from end for the convenience of removing an item.
    for (var i = sdpLines.length - 1; i >= 0; i--) {
        var payload = extractSdp(sdpLines[i], /a=rtpmap:(\d+) CN\/\d+/i);
        if (payload) {
            var cnPos = mLineElements.indexOf(payload);
            if (cnPos !== -1) {
                // Remove CN payload from m line.
                mLineElements.splice(cnPos, 1);
            }
            // Remove CN line in sdp
            sdpLines.splice(i, 1);
        }
    }

    sdpLines[mLineIndex] = mLineElements.join(' ');
    return sdpLines;
}
