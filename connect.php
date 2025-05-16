<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB config
$servername = "localhost";
$username = "root";
$password = "";
$database = "event_management";

// Get POST data
$name = $_POST['name'] ?? '';
$event_date = $_POST['date'] ?? '';
$event_time = $_POST['time'] ?? '';
$event_name = $_POST['event'] ?? '';

// Connect to DB
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert data
$stmt = $conn->prepare("INSERT INTO events (name, event_date, event_time, event_name) VALUES (?, ?, ?, ?)");
if (!$stmt) die("Prepare failed: " . $conn->error);

$stmt->bind_param("ssss", $name, $event_date, $event_time, $event_name);

if ($stmt->execute()) {
  echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
    <meta charset='UTF-8'>
    <title>Thank You</title>
    <link href='https://fonts.googleapis.com/css2?family=Prosto+One&display=swap' rel='stylesheet'>
    <style>
        @font-face {
        font-family: 'curved';
        src: url('Montsera.ttf');
        }
        body {
        margin: 0;
        font-family: 'Prosto One', sans-serif;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
        overflow: hidden;
        background: url('background.png');
        }

        .nav {
        position: absolute;
        top: 0;
        width: 100%;
        z-index: 2;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px 0;
        }

    .logo a {
    font-family: 'curved', sans-serif;
    color: #fff;
    font-size: 36px;
    text-decoration: none;
    }
        .card {
        background: rgba(224, 170, 62, 0.1);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 60px 40px;
        width: 90%;
        max-width: 1000px;
        text-align: center;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
        animation: fadeIn 0.8s ease;
        z-index: 1;
        }

        .card h1 {
        font-size: 42px;
        color: #e0aa3e;
        margin-bottom: 40px;
        }

        .details p {
        font-size: 24px;
        color: #f5f5f5;
        margin: 16px 0;
        }

        .logo a {
        font-family: 'curved', sans-serif;
        color: #e0aa3e;
        font-size: 32px;
        text-decoration: none;
        }

        @keyframes fadeIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
        }

        button {
        --button_radius: 0.75em;
        --button_color: #e8e8e8;
        --button_outline_color: #000000;
        font-size: 17px;
        font-weight: bold;
        border: none;
        border-radius: var(--button_radius);
        background: var(--button_outline_color);
        margin-top: 20px;
        cursor: pointer;
        }

        .button_top {
        display: block;
        box-sizing: border-box;
        border: 2px solid var(--button_outline_color);
        border-radius: var(--button_radius);
        padding: 0.75em 1.5em;
        background: linear-gradient(to top right, #111, #e0aa3e);
        color: var(--button_outline_color);
        transform: translateY(-0.2em);
        transition: transform 0.1s ease;
        }

        button:hover .button_top {
        transform: translateY(-0.33em);
        }

        button:active .button_top {
        transform: translateY(0);
        }
    </style>
    </head>
    <body>
    <!-- Centered Logo Nav -->
        <nav class='nav' aria-label='Main Navigation'>
        <div class='logo'>
            <a href='index.html'>RaveBase</a>
        </div>
        </nav>

    <div class='card'>
        <img src='qr.png' alt='Success Icon' style='width: 210px; margin-bottom: 30px;border-radius: 20px;' />
        <h1>Registration Successful!</h1>
        <div class='details'>
        <p>Name: <strong>$name</strong></p>
        <p>Time: $event_date at $event_time</p>
        <p>Event: $event_name</p>
        </div>
        <button onclick=\"window.location.href='index.html';\">
        <span class='button_top'>⬅ Back to Home</span>
        </button>
    </div>
    </body>
    </html>
";

}
else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
