<?php

$url = "https://gnews.io/api/v4/search?q=supply%20chain";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 20);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$result = curl_exec($ch);

if (curl_errno($ch)) {
    echo "ERROR : ".curl_error($ch);
} else {
    echo "BERHASIL";
}

curl_close($ch);