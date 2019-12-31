<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include "includes/config.php";
session_start();

$data = json_decode(file_get_contents("php://input"));
if (
    !empty($data->idIser) &&
    !empty($data->idTarget)
) {
    $ID1 = $data->idIser;
    $ID2 = $data->idTarget;

    $query = "INSERT INTO requests (`id1`, `id2`)
            VALUES ('$ID1','$ID2')";
    $stmt = $conn->prepare($query);
    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode(array("message" => "Friend request sent."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to send friend request."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to send friend request. Data is incomplete."));
}
