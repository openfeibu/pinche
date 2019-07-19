<?php

class openid
{
    public function wxid()
    {
        if (isset($_REQUEST['code'])) {
            $appid = 'wx0ad889e6cbca5d19';
            $appsecret = '71678a9a02789838965c3feb17ed66db';
            $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $appid . '&secret=' . $appsecret . '&js_code=' . $_REQUEST['code'] . '&grant_type=authorization_code';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, FALSE);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($curl, CURLOPT_HEADER, FALSE);
            $rst = curl_exec($curl);
            $e = curl_error($curl);
            curl_close($curl);
            if ($rst) {
               
                print_r($rst);
            } else {
                print_r($e);
            }
        } else {
            echo '未获取到code';
        }
    }
}

$m = new openid();
$re = $m->wxid();
echo $re;