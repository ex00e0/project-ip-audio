<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audio Player</title>
</head>
<body>
    <div id="audio-player">
        <audio controls>
            <source src="{{asset('audio/Calm_music_-_Zeon_73851765.mp3')}}" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    </div>

    <script>
        // document.addEventListener('DOMContentLoaded', function () {
        //     new MediaPlayer('audio-player');
        // });
    </script>
</body>
</html>