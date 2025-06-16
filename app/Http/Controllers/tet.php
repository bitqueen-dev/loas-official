<?php
$paras = array(
    'op_id' => $currentServerInfo['opId'],
    'sid' => $currentServerInfo['serverId'],
    'game_id' => $currentServerInfo['gameId'],
    'account' => $accountId,
    'adult_flag' => 1,
    'game_time' => $currentTime,
    'ip' => $remoteIP,
    'ad_info' => null,
    'time' => $currentTime,
);
$auth = base64_encode(http_build_query($paras));
$verify = md5($auth . $key);

// 封装登录链接，调起flash
$requestUrl= "//pay.loas.jp/api/accessport/login?auth=$auth&verify=$verify";

// 登录链接会302重定向到https://webout.loas.jp/game?xxxx
// 这里从重定向header中取得目标地址
// 拼接成loas2mclient://https://webout.loas.jp/game?xxxx 调起微端
$headers = get_headers($requestUrl,1);
if ($headers && $headers['location']){
    $startWeiClientUrl = 'loas2mclient://'.$headers['location'];
}