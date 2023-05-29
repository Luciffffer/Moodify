document.querySelector('#playpause').addEventListener('click', e => {
    e.preventDefault();
    const token = document.body.dataset.token;
    
    myHeaders = new Headers();
    myHeaders.append('Authorization', 'Bearer ' + token);
    myHeaders.append('Content-Type', 'application/json');

    fetch('https://api.spotify.com/v1/me/player/play', {
        method: 'PUT',
        headers: myHeaders,
    })
        .catch(error => {
            console.error(error);
        });
});
