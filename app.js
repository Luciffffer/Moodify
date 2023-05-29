let happyTracks = [];
let sadTracks = [];
let angryTracks = [];

window.addEventListener('load', () => {
    fetch('api/get-top-songs.ajax.php')
        .then(response => response.json())
        .then(json => {
            if (json.status = 'error') {
                throw json.message;
            }

            happyTracks = json.tracks.happy;
            sadTracks = json.tracks.sad;
            angryTracks = json.tracks.angry;
        })
        .catch(error => {
            console.error(error);
        });
});
