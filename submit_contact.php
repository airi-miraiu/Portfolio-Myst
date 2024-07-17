<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myst";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // Initialize the message variable

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"])) {
    $email = $conn->real_escape_string($_POST["email"]);
    $sql = "INSERT INTO contacts (email) VALUES ('$email')";
    
    if ($conn->query($sql) === TRUE) {
        $message = "<div class='success-message'>
                        <h1>Thank you for your submission!</h1>
                        <p>May we myst your life with miracles</p>
                    </div>";
    } else {
        $message = "<div class='error-message'>
                        <p>Error: " . $sql . "<br>" . $conn->error . "</p>
                    </div>";
    }
} else {
    $message = "<div class='error-message'>
                    <p>No data was submitted.</p>
                </div>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .success-message, .error-message {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .success-message h1 {
            color: #d8a1b4;
        }
        .success-message p {
            color: #a1c4d8;
        }
        .error-message p {
            color: #d88a8a;
        }
    </style>
</head>
<body>
    <?php echo $message; ?>
</body>
</html>
