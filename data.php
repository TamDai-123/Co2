<?php
header('Content-Type: application/json');

// ข้อมูลการเชื่อมต่อฐานข้อมูล
$host = "cvktne7b4wbj4ks1.chr7pe7iynqr.eu-west-1.rds.amazonaws.com";
$username = "vcd4hvgvbnfmihrx";
$password = "et7jdh15ukis1krh";
$dbname = "cza3tygsyezpf1wf";
$port = 3306; // MySQL Port

$conn = new mysqli($host, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

// ดึงข้อมูล 24 ชั่วโมงย้อนหลัง
$sql = "
SELECT 
    DATE_FORMAT(Date_Time, '%Y-%m-%d %H:00:00') as hour,
    ROUND(AVG(Co2), 2) as avg_co2,
    ROUND(AVG(TVOC), 2) as avg_tvoc
FROM co2_data
WHERE Date_Time >= NOW() - INTERVAL 24 HOUR
GROUP BY hour
ORDER BY hour ASC
";

$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Query failed: " . $conn->error]);
    exit;
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
