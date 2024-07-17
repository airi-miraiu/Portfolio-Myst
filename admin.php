<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #1c1c1c;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.6);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h1 {
            color: #d8a1b4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #d8a1b4;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #d8a1b4;
            color: #fff;
        }
    </style>
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myst";

// to create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// to check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_id"])) {
    $delete_id = $conn->real_escape_string($_POST["delete_id"]);
    $sql_delete = "DELETE FROM contacts WHERE id = '$delete_id'";
    
    if ($conn->query($sql_delete) === TRUE) {
        echo "♡Data Exterminated♡";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$sql = "SELECT id, email, created_at FROM contacts";
$result = $conn->query($sql);

if ($result === false) {
    die("Error: " . $conn->error);
}
?>
    <div class="container">
        <h1>Welcome back, Admin</h1>
        <h2>List of Client Submissions</h2>
        <table>
            <tr>
                <th width="7%">ID</th>
                <th width="39%">Email</th>
                <th width="39%">Submitted at</th>
                <th width="15%">Drop data</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["id"] . "</td>
                            <td>" . $row["email"] . "</td>
                            <td>" . $row["created_at"] . "</td>
                            <td>
                                <form method='POST' action='admin.php'>
                                    <input type='hidden' name='delete_id' value='" . $row["id"] . "'>
                                    <button type='submit'>Delete</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No submissions found</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>
