<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include "includes/config.php";

$data = json_decode(file_get_contents("php://input"));
if (
    !empty($data->id)
) {
    $userID = $data->id;
    $users_arr = array();
    $users_arr["requests"] = array();

    $query = "SELECT * FROM requests Where id2 = '$userID'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count > 0) {

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $requestId = $id;
            $id = $id1;
            $query = "SELECT * FROM user Where id = '$id'";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $row1 = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row1);
            $userName = $name;

            $user = array(
                "id" => $requestId,
                "userId" => $id,
                "Name" => $userName,
            );

            array_push($users_arr["requests"], $user);
        }

        http_response_code(200);
        echo json_encode($users_arr);

    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No friend requests."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to get friend requests. Data is incomplete."));
}
