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
    !empty($data->id)
) {
    $ID = $data->id;

    $query = "SELECT * FROM requests Where id = '$ID'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
        $ID1 = $id1;
        $ID2 = $id2;
        $query = "INSERT INTO friends (`id1`, `id2`)
        VALUES ('$ID1','$ID2')";
        $stmt = $conn->prepare($query);
        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(array("message" => "Friend request accepted."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to accept friend request."));
        }
    }

} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to accept friend request. Data is incomplete."));
}
