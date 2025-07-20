<?php
// ข้อมูลการเชื่อมต่อฐานข้อมูล
$host = "cvktne7b4wbj4ks1.chr7pe7iynqr.eu-west-1.rds.amazonaws.com";
$username = "vcd4hvgvbnfmihrx";
$password = "et7jdh15ukis1krh";
$dbname = "cza3tygsyezpf1wf";
$port = 3306; // MySQL Port

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
