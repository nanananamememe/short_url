<?php
require 'vendor/autoload.php';
Predis\Autoloader::register();
$domain = getenv('HTTP_HOST');
$redisUrl = getenv('REDIS_URL');
if (!$redisUrl) {
    echo 'heroku-redisアドオン作成中。しばらくお待ち下さい...';
    exit;
}
$redis = new Predis\Client($redisUrl);
$url = empty($_POST['url'])?null:trim($_POST['url']);
$key = trim(getenv('REQUEST_URI'), '/');
if ($url) {
    if (!preg_match('/^https?:\/\//', $url)) {
        $url = 'http://' . $url;
    }
    $hash = strtr(trim(base64_encode(crc32(md5($url))), '='), '+/', '-_');
    $redis->set($hash, $url); //セット
    $redis->expire($hash, 43260); //期限の設定(秒)
}
if ($key) {
    $redirect = $redis->get($key); //取得
    if ($redirect) {
        header("Location: {$redirect}");
    } else {
        echo 'このURLの有効期限は切れました。';
        exit;
    }
} else {
    $jump = "http://{$domain}/{$hash}";
    require 'form.php';
}
