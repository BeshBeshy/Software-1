<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include "includes/config.php";

$data = json_decode(file_get_contents("php://input"));
if (
    !empty($data->email) &&
    !empty($data->password)
) {
    $Email = $data->email;
    $Pass = $data->password;
    $password = md5($Pass);

    $query = "SELECT * FROM User Where email = '$Email' AND password = '$password' ";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {
        http_response_code(202);
        echo json_encode(array("message" => "logged in succefuuly."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to log in."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to log in. Data is incomplete."));
}
