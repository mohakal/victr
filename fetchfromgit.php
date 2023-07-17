<?php
require("database.php");
$response = [];
$git_data = [];
$response_status = 200;
$access_token = "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";
try {
// API endpoint to get the most-starred PHP projects
    $url = 'https://api.github.com/search/repositories?q=language:php&sort=stars&order=desc';
// Set the Authorization header with the access token
    $headers = array(
        'Authorization: token ' . $access_token,
        'User-Agent: PHP'
    );
// Initialize cURL session
    $ch = curl_init();
// Set the cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Execute the cURL request
    $response = curl_exec($ch);
// Check if the request was successful (status code 200)
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //dump($response);
    if ($status_code == 200) {
        $data = json_decode($response, true);
        // Iterate over the items to retrieve repository information
        $i = 0;
        foreach ($data['items'] as $item) {
            $git_data[$i]['id'] = $item['id'];
            $git_data[$i]['name'] = $item['name'];
            $git_data[$i]['html_url'] = $item['html_url'];
            $git_data[$i]['created_at'] = $item['created_at'];
            $git_data[$i]['pushed_at'] = $item['pushed_at'];
            $git_data[$i]['description'] = $item['description'];
            $git_data[$i]['stargazers_count'] = $item['stargazers_count'];
            $i++;
        }
        $datbase = new database();
        $result = $datbase->saveDataInDb($git_data);
        $response_message = "Data Saved In DB";
        if (!$result) {
            $response_status = '101';
            $response_message = "DB error";
        }
    } else {
        $response_status = '101';
        $response_message = "Curl Error: Status Code:" . $status_code;
    }
    curl_close($ch);
} catch (Exception $ex) {
    $response_status = '100';
    $response_message = $ex->getMessage();
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode(['status' => $response_status, 'message' => $response_message]);



