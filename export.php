<?php
// ข้อมูลการเชื่อมต่อฐานข้อมูล
$host = "cvktne7b4wbj4ks1.chr7pe7iynqr.eu-west-1.rds.amazonaws.com";
$username = "vcd4hvgvbnfmihrx";
$password = "et7jdh15ukis1krh";
$dbname = "cza3tygsyezpf1wf";
$port = 3306; // MySQL Port

// สร้างการเชื่อมต่อ
$conn = new mysqli($host, $username, $password, $dbname, $port);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตั้งค่าหัวข้อ CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=co2_data.csv');

// เปิด output stream
$output = fopen('php://output', 'w');
if (!$output) {
    die("Unable to open output stream");
}

// เขียนหัวข้อคอลัมน์
fputcsv($output, array('ID', 'Co2', 'Tvoc', 'Date_Time', 'Status'));

// ดึงข้อมูลจากฐานข้อมูล
$sql = "SELECT ID, Co2, Tvoc, Date_Time, status FROM co2_data";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // เขียนข้อมูลลงใน CSV
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
} else {
    // หากไม่มีข้อมูล
    fputcsv($output, array("No data found"));
}

// ปิดการเชื่อมต่อ
$conn->close();
fclose($output);
?>
