<?php
/*
 * @Author: gogoend
 * @Date: 2020-06-22 01:22:49
 * @LastEditors: gogoend
 * @LastEditTime: 2020-07-03 22:31:22
 * @FilePath: \git-webhook\index.php
 * @Description: 
 */

if (file_exists('auth-config.php')) {
    include('auth-config.php');
} else {
    echo '发生错误 - 配置文件无效';
    return http_response_code(404);
}
$secretInHeader = null;
$requestSource = null;
$requestHeader = getallheaders();
$requestBody = file_get_contents("php://input");


if(array_key_exists('X-Gitee-Token',$requestHeader)){
    $requestSource = 'gitee';
    $secretInHeader = $requestHeader['X-Gitee-Token'];
}
if(array_key_exists('X-Hub-Signature',$requestHeader)){
    $requestSource = 'github';
    $secretInHeader = $requestHeader['X-Hub-Signature'];
}

// var_dump($requestHeader);

if(!$secretInHeader || !$requestSource){
    echo '发生错误 - 请求无效';
    return http_response_code(404);
}

if ($requestSource==='github') {
    // 来自GitHub的请求
    list($algo, $hash) = explode('=', $secretInHeader, 2);
    $payloadHash = hash_hmac($algo, $requestBody, SECRET_KEY);
    echo $payloadHash.'   ';
    echo $hash;
    if ($hash !== $payloadHash) {
        echo '发生错误 - 签名无效';
        return http_response_code(404);
    }
} else if ($requestSource==='gitee')  {
    // 来自Gitee的请求
    if ($secretInHeader !== SECRET_KEY) {
        echo '发生错误 - 令牌无效';
        return http_response_code(404);
    }
}
echo '鉴权成功';
var_dump(
    json_decode($requestBody)
);
