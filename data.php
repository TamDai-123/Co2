<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$password = "zong2411";
$dbname = "project_co2";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}

// ดึงข้อมูล 24 ชั่วโมงย้อนหลัง
$sql = "
SELECT 
    DATE_FORMAT(Date_Time, '%Y-%m-%d %H:00:00') as hour,
    AVG(Co2) as avg_co2,
    AVG(TVOC) as avg_tvoc
FROM co2_data
WHERE Date_Time >= NOW() - INTERVAL 24 HOUR
GROUP BY hour
ORDER BY hour ASC
";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
