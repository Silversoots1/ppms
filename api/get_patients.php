<?php

function getAccessToken()
{

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 
    "https://rtdemo.raintreeinc.com/webapidev/api/token");

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'grant_type' => 'client_credentials',
        'client_id' => '3e2f0bbc670e01095722f014',
        'client_secret' => '2a90ad8b3dd5f8565aec4b63739852f5'
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'AppId: EHbM4U-QaHAt26U-SIMU9-3jtmJK'
    ]);

    $response = curl_exec($ch);

    if(curl_errno($ch)) {
        return false;
    } else {
        $data = json_decode($response, true);
        curl_close($ch);    

        return $data['access_token'];
    }

}

$access_token = getAccessToken();

if(!$access_token)
{
    die;
}

$ch = curl_init();

$url = "https://rtdemo.raintreeinc.com/webapidev/api/patients?first_name=Patricia&last_name=Doe&dob=1955-03-02&email=patricia@doemail.com";

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $access_token  // Replace $access_token with your actual token
));

$response = curl_exec($ch);

if(curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    $data = json_decode($response, true);
    echo '<pre>';
    print_r($data);
}


$url = "https://rtdemo.raintreeinc.com/webapidev/api/patients/0000650";

curl_setopt($ch, CURLOPT_URL, $url);
$response = curl_exec($ch);

if(curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    $data = json_decode($response, true);
    echo '<pre>';
    print_r($data);
}


curl_close($ch);
