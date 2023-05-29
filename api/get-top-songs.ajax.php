<?php

// In seperate file because processing will take a while
// This file is called by app.js

session_start();

try {

    if (isset($_SESSION['access_token'])) {
        
        $limit = 100;
        $page = 1;

        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }

        $offset = ($page - 1) * $limit;

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.spotify.com/v1/me/top/tracks?limit=' . $limit . '&offset=' . $offset,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $_SESSION['access_token'],
                'Content-Type: application/x-www-form-urlencoded'
            ],
            CURLOPT_HEADER => false
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response, true);
        $tracks = $data['items'];

        // get id of each track
        $trackIds = [];

        foreach($tracks as $track) {
            array_push($trackIds, $track['id']);
        }

        // request track features
        $curl = curl_init();

        $url = 'https://api.spotify.com/v1/audio-features?ids=' . implode(',', $trackIds);
        
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $_SESSION['access_token'],
                'Content-Type: application/x-www-form-urlencoded'
            ],
            CURLOPT_HEADER => false
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response, true);

        // filter tracks based on emotion

        $happyTracks = [];
        $sadTracks = [];
        $angryTracks = [];

        foreach($data['audio_features'] as $index => $track) {
            if ($track['valence'] > 0.5 && $track['mode'] == 1) {
                array_push($happyTracks, $tracks[$index]['uri']);
            } else if ($track['valence'] < 0.5 && $track['mode'] == 0 && $track['energy'] < 0.6) {
                array_push($sadTracks, $tracks[$index]['uri']);
            } 
            
            if ($track['energy'] > 0.7 && $track['valence'] < 0.6) {
                array_push($angryTracks, $tracks[$index]['uri']);
            }
        }

        $response = [
            'status' => 'success',
            'tracks' => [
                'happy' => $happyTracks,
                'sad' => $sadTracks,
                'angry' => $angryTracks
            ]
        ];

    } else {
        throw new Exception('Must be logged in to access this page');
    }

} catch (Throwable $err) {
    $response = [
        'status' => 'error',
        'message' => $err->getMessage()
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
