<?php

$login = 'IPT_ADMIN';
$password = 'U6-km(jD8a68r';
$url = 'https://qa.cienciavitae.pt/api/v1.1/curriculum/2A13-632C-D743/output?lang=User%20defined';
$ch = curl_init();


$headers = array(
    "Content-Type: application/json",
    "Accept: application/json",
 );



curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");




$result = curl_exec($ch);

curl_close($ch);

print_r($result);



?>