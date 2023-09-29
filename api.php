<?php
header("Content-Type: application/json");

$servername = "localhost";
$username = "your_user";
$password = "your_password";
$dbname = "tasks";

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $sql = "SELECT * FROM tasks";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $tasks = array();

        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }

        echo json_encode($tasks);
    } else {
        echo json_encode(array());
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $task = $data["task"];
    
    $sql = "INSERT INTO tasks (task) VALUES ('$task')";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Task added"));
    } else {
        echo json_encode(array("error" => $conn->error));
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data["id"];
    
    $sql = "DELETE FROM tasks WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Task deleted"));
    } else {
        echo json_encode(array("error" => $conn->error));
    }
}

$conn->close();
?>
