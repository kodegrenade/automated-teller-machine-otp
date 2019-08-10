<?php
# Function for sending sms to user
function AuthOtp($url, array $params){
    # send otp to user phone
    # code...
    $params = http_build_query($params);
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

    $output = curl_exec($ch);

    curl_close($ch);
    return $output;
}