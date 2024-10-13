<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
include '../db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $db->prepare(" INSERT INTO services (service_id, service_name, description, duration, price) VALUES (NULL,:service_name,:description,:duration,:price) ");
        $stmt->bindParam(':service_name', $_POST['service_name'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
        $stmt->bindParam(':duration', $_POST['duration'], PDO::PARAM_INT);
        $stmt->bindParam(':price', $_POST['price'], PDO::PARAM_INT);
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
