<?php
ob_start();
$variable = 1;
switch ($variable) {
	case 1:
		// Mamp
		define('LOCALHOST', 'localhost');
		define('DB_USERNAME', 'root');
		define('DB_PASSWORD', 'root');
		define('DB_NAME', 'db_spa_api');
		break;
	case 2:
		// Hosting
		define('LOCALHOST', 'localhost');
		define('DB_USERNAME', '');
		define('DB_PASSWORD', '');
		define('DB_NAME', '');
		break;
}

$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}
mysqli_query($conn, 'set NAMES utf8mb4');
mysqli_query($conn, 'SET character_set_results=utf8mb4');
mysqli_query($conn, 'SET character_set_client=utf8mb4');
mysqli_query($conn, 'SET character_set_connection=utf8mb4');
date_default_timezone_set('Asia/Bangkok');
