<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include "includes/config.php";

$data = json_decode(file_get_contents("php://input"));
if (
    !empty($data->name) &&
    !empty($data->email) &&
    !empty($data->gender) &&
    !empty($data->password)
) {
    $Name = $data->name;
    $Email = $data->email;
    $Gender = $data->gender;
    $Pass = $data->password;
    $password = md5($Pass);

    $query = "INSERT INTO User (`name`, `email`, `password`, `gender`)
            VALUES ('$Name','$Email','$password','$Gender')";
    $stmt = $conn->prepare($query);
    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode(array("message" => "Account was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create account."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create account. Data is incomplete."));
}
