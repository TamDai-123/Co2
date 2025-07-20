<?php
// ข้อมูลการเชื่อมต่อฐานข้อมูล
$host = "cvktne7b4wbj4ks1.chr7pe7iynqr.eu-west-1.rds.amazonaws.com";
$username = "vcd4hvgvbnfmihrx";
$password = "et7jdh15ukis1krh";
$dbname = "cza3tygsyezpf1wf";
$port = 3306; // MySQL Port
// ตั้งค่า timezone
date_default_timezone_set("Asia/Bangkok");

// สร้างการเชื่อมต่อ
$conn = new mysqli($host, $username, $password, $dbname, $port);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// ตรวจสอบว่ามีค่าที่ส่งผ่าน URL หรือไม่
if (isset($_GET['Co2']) && isset($_GET['Tvoc'])) {
    // รับค่าจาก URL
    $co2 = $_GET['Co2'];
    $tvoc = $_GET['Tvoc'];
    $timestamp = date("Y-m-d H:i:s"); // เวลาปัจจุบัน

    // ตรวจสอบว่าค่าเป็นตัวเลข
    if (is_numeric($co2) && is_numeric($tvoc)) {
        // ใช้ prepared statement
        $stmt = $conn->prepare("INSERT INTO co2no_data (Co2, Tvoc, DATE) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $co2, $tvoc, $timestamp);

        // ดำเนินการเพิ่มข้อมูล
        if ($stmt->execute()) {
            echo "เพิ่มข้อมูลสำเร็จ! Co2: $co2, Tvoc: $tvoc, เวลา: $timestamp";
        } else {
            echo "ข้อผิดพลาด: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "ค่า Co2 และ Tvoc ต้องเป็นตัวเลข";
    }
} else {
    echo "กรุณาระบุข้อมูล Co2 และ Tvoc ผ่าน URL เช่น ?Co2=400&Tvoc=150";
}

// ปิดการเชื่อมต่อ
$conn->close();
?>
