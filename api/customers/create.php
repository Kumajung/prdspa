<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
include '../db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $db->prepare(" INSERT INTO customers (customer_id, first_name, last_name, email, phone,created_at) VALUES (NULL,:first_name,:last_name,:email,:phone,CURRENT_TIMESTAMP) ");
        $stmt->bindParam(':first_name', $_POST['first_name'], PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $_POST['last_name'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
        $stmt->bindParam(':phone', $_POST['phone'], PDO::PARAM_STR);
        $stmt->execute();
        echo json_encode(['msg'=>'success'], JSON_UNESCAPED_UNICODE);
        $db = null;
    } catch (PDOException $e) {
        json_encode(['msg' => 'Error: ' . $e->getMessage()]);
        die();
    }
} else {
    echo json_encode(['msg' => 'Method Not Allowed']);
    http_response_code(405);
}
