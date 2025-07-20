<?php
// ข้อมูลการเชื่อมต่อฐานข้อมูล
$host = "localhost";
$username = "root";
$password = "zong2411";
$dbname = "project_co2";
$port = 3306; // MySQL Port (ค่าเริ่มต้นคือ 3306)

// สร้างการเชื่อมต่อ
$conn = new mysqli(hostname: $host, username: $username, password: $password, database: $dbname, port: $port);


?>
