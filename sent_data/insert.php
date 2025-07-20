<?php
$servername = "localhost";
$username = "root";
$password = "zong2411";
$dbname = "project_co2";

// รับค่าจาก POST
$co2 = isset($_POST['co2']) ? $_POST['co2'] : null;
$tvoc = isset($_POST['tvoc']) ? $_POST['tvoc'] : null;

// ตรวจสอบค่าที่ได้รับ
if (!is_numeric($co2) || !is_numeric($tvoc)) {
    echo "Missing POST data: co2 tvoc";
    exit;
}

// เชื่อมต่อ MySQL
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// บันทึกข้อมูล
$sql = "INSERT INTO co2_data (Co2, Tvoc) VALUES ($co2, $tvoc)";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
