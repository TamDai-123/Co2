<?php
$host = "localhost";
$username = "root";
$password = "zong2411";
$dbname = "project_co2";
$port = 3306;

$conn = new mysqli($host, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed']));
}

$sql = "SELECT Co2, Tvoc, status, Date_Time FROM co2_data ORDER BY Date_Time DESC LIMIT 1";
$result = $conn->query($sql);

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        'co2' => $row['Co2'],
        'tvoc' => $row['Tvoc'],
        'status' => $row['status'],
        'datetime' => $row['Date_Time']
    ]);
} else {
    echo json_encode(['error' => 'No data found']);
}

$conn->close();
?>
