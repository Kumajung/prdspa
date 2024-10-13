<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
include '../db.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $services = array();
        foreach ($db->query('SELECT * FROM services') as $row) {
            $service = array(
                'service_id' => $row['service_id'],
                'service_name' => $row['service_name'],
                'description' => $row['description'],
                'duration' => (double)$row['duration'],
                'price' => (double)$row['price']
            );
            array_push($services, $service);
        }
        echo json_encode($services, JSON_UNESCAPED_UNICODE);
        $db = null;
    } catch (PDOException $e) {
        json_encode(['msg' => 'Error: ' . $e->getMessage()]);
        die();
    }
}else{
    echo json_encode(['msg' => 'Method Not Allowed']);
    http_response_code(405);
}
