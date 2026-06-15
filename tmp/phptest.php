<?php
chdir('/var/www/vhosts/hseipaa.kz/in.hseipaa.kz');
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = config('bereke.username');
$pass = config('bereke.password');

echo 'username=[' . $user . ']' . PHP_EOL;
echo 'password=[' . $pass . ']' . PHP_EOL;

$data = [
    'userName'    => $user,
    'password'    => $pass,
    'orderNumber' => 'PHPTEST' . time(),
    'amount'      => 345000,
    'currency'    => 398,
    'returnUrl'   => 'https://in.hseipaa.kz/cabinet/payment/return',
    'description' => 'test tarif',
    'language'    => 'ru',
];

$body = http_build_query($data);
echo 'Body: ' . preg_replace('/password=[^&]+/', 'password=***', $body) . PHP_EOL;

$ch = curl_init('https://securepayments.berekebank.kz/payment/rest/register.do');
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $body,
    CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_TIMEOUT        => 30,
]);
$res  = curl_exec($ch);
$err  = curl_error($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo 'HTTP: ' . $code . PHP_EOL;
echo 'CURL error: ' . $err . PHP_EOL;
echo 'Response: ' . $res . PHP_EOL;
