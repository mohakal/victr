<?php
require("database.php");
$response['status'] = "400";
$reposne['message'] = "Error! Method need to be GET";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // db call
        $datbase = new database();
        $result = $datbase->searchFromDB();
        $response['status'] = $result["status"];
        $response['message'] = $result["message"];
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
?>