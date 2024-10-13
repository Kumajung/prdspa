<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");

include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    try {
        $_POST = json_decode(file_get_contents('php://input'), true);

        $stmt = $db->prepare(" UPDATE services SET service_name = :service_name, 
                            description = :description,
                            duration = :duration, 
                            price = :price
                            WHERE service_id = :service_id ");

        $stmt->bindParam(':service_name', $_POST['service_name'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
        $stmt->bindParam(':duration', $_POST['duration'], PDO::PARAM_INT);
        $stmt->bindParam(':price', $_POST['price'], PDO::PARAM_INT);
        $stmt->bindParam(':service_id', $_POST['edit_id'], PDO::PARAM_INT);

        // service_name description duration price edit_id
        $stmt->execute();
        echo json_encode(['msg' => 'success'], JSON_UNESCAPED_UNICODE);

        $db = null;
    } catch (PDOException $e) {
        echo json_encode(['msg' => 'Error: ' . $e->getMessage()]);
        http_response_code(500);
    }
} else {
    // Return Method Not Allowed response
    echo json_encode(['msg' => 'Method Not Allowed']);
    http_response_code(405);
}
