<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include "includes/config.php";

$data = json_decode(file_get_contents("php://input"));
if (
    !empty($data->name)
) {
    $Name = $data->name;
    $op1 = '%';
    $name1 = $op1 . $Name . $op1;
    $users_arr = array();
    $users_arr["requests"] = array();
    $query = "SELECT * FROM User Where name LIKE '$name1'";
    $stmt1 = $conn->prepare($query);
    $stmt1->execute();
    $num = $stmt1->rowCount();
    if ($num > 0) {

        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $user = array(
                "id" => $id,
                "Name" => $name,
            );

            array_push($users_arr["requests"], $user);
        }

        http_response_code(200);
        echo json_encode($users_arr);
    } else {
        http_response_code(404);

        echo json_encode(array("message" => "No users found."));

    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to search for account. Data is incomplete."));
}