<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="5;url={{ url('/') }}">
    <title>Too Many Attempts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background: #FCD7DE;
        }
        .container {
            background: white;
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #E53E3E;
            margin-bottom: 20px;
        }
        p {
            color: #4A5568;
            font-size: 18px;
            line-height: 1.6;
        }
        .countdown {
            font-weight: bold;
            color: #E53E3E;
        }
        .home-button {
            display: inline-block;
            background-color: #E53E3E;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .home-button:hover {
            background-color: #C53030;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>BALIK WOI</h1>
        <p>DIBILANG CUMA BISA SEKALI</p>
        <p>You will be redirected to the home page in <span id="countdown" class="countdown">10</span> seconds.</p>
        <a href="{{ url('/') }}" class="home-button">Pencet kalo ga sabar</a>
        <div id="flag" style="display: none; margin-top: 20px; color: #E53E3E; font-weight: bold;">
            🚩 pisang{y0u_c4nt_d0_qu1z_tw1c3}
        </div>
    </div>

    <script>
        let seconds = 5;
        const countdownElement = document.getElementById('countdown');
        const flagElement = document.getElementById('flag');
        
        const countdown = setInterval(() => {
            seconds--;
            countdownElement.textContent = seconds;
            if (seconds <= 0) {
                clearInterval(countdown);
                flagElement.style.display = 'block'; // Show flag when countdown ends
            }
        }, 1000);
    </script>
</body>
</html>