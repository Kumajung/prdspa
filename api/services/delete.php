<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");

include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);

        $stmt = $db->prepare(" DELETE FROM services WHERE service_id = :service_id ");
        $stmt->bindParam(':service_id', $data['id'], PDO::PARAM_INT);

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
