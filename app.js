const video = document.querySelector('#webcam');

let happyTracks = [];
let sadTracks = [];
let angryTracks = [];

let emotion = 'happy';
let newEmotion = 'happy';
let previousNewEmotion = 'happy';

function startWebcam() {
    navigator.getUserMedia(
        { video: {} },
        stream => video.srcObject = stream,
        err => console.error(err)       
    )
}

async function changeSongs(tracks) {
    const myHeaders = new Headers();
    myHeaders.append('Authorization', 'Bearer ' + document.body.dataset.token);
    myHeaders.append('Content-Type', 'application/json');

    const res = await fetch('https://api.spotify.com/v1/me/player/play', {
        method: 'PUT',
        headers: myHeaders,
        body: JSON.stringify({
            uris: tracks,
            offset: {
                position: Math.floor(Math.random() * tracks.length)
            } 
        })
    });
}

window.addEventListener('load', async () => {
    try {

        // load models
        await faceapi.nets.tinyFaceDetector.loadFromUri('assets/models');
        await faceapi.nets.faceLandmark68Net.loadFromUri('assets/models');
        await faceapi.nets.faceRecognitionNet.loadFromUri('assets/models');
        await faceapi.nets.faceExpressionNet.loadFromUri('assets/models');

        // get top songs
        const res = await fetch('api/get-top-songs.ajax.php');
        const json = await res.json();

        if (json.status == 'error') {
            throw json.message;
        }

        happyTracks = json.tracks.happy;
        sadTracks = json.tracks.sad;
        angryTracks = json.tracks.angry;

        startWebcam();

    } catch (err) {
        console.error(err);
    }
});

video.addEventListener('play', () => {
    setInterval(async () => {
        const detections = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions()).withFaceExpressions();
        
        if (!detections) return;
        
        // get expression with highest value
        const expression = Object.entries(detections.expressions).reduce((a, b) => a[1] > b[1] ? a : b)[0];

        if (expression == 'neutral') return;

        previousNewEmotion = newEmotion;

        if (expression == 'happy' || expression == 'surprised') {
            newEmotion = 'happy';
        } else if (expression == 'sad') {
            newEmotion = 'sad';
        } else if (expression == 'angry' || expression == 'disgusted') {
            newEmotion = 'angry';
        }

        if (newEmotion == emotion) return;

        if (newEmotion != previousNewEmotion) {
            let timer;
            if (timer) clearTimeout(timer);

            timer = setTimeout(() => {
                emotion = newEmotion;
                console.log(emotion);
                
                switch (emotion) {
                    case 'happy':
                        changeSongs(happyTracks);
                        break;
                    case 'sad':
                        changeSongs(sadTracks);
                        break;
                    case 'angry':
                        changeSongs(angryTracks);
                        break;
                }
                
                clearTimeout(timer);
            }, 5000);
        }

    }, 1000);
});
