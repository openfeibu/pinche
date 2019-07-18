<?php
/**
 * 承德博智网络科技有限公司
 * User: service@cdbozhi.com
 * Date: 16/10/27
 * Time: 下午12:57
 */

namespace app\core\comp\phone;


use app\core\CacheKeys;
use app\core\Http;
use app\core\ResultMsg;
use app\core\XConfig;
use think\Cache;
use think\Exception;
use think\Request;
use traits\think\Instance;

class PhoneCodeSender {
    use Instance;




    /**
     * @param $phone string 手机号
     * @param $type  int    验证码类型
     * @throws Exception  验证码发送失败
     */
    public function sendCode($phone,$type,$ipCheck=true){
        if($ipCheck){
          $ip=Request::instance()->ip();
            $last=Cache::get(CacheKeys::$phone_code_.$ip);
           if($last){
               throw  new Exception(ResultMsg::phone_code_send_exits);
           }
           Cache::set(CacheKeys::$phone_code_.$ip,"11",60);
        }
        $phoneCode= new PhoneCode();
        $phoneCode->setCreateTime(time());
        $phoneCode->setStatus(0);
        $phoneCode->setUserId(1);
        $phoneCode->setPhone($phone);
        $phoneCode->setType($type);
        $code= $this->send($phone);
        $phoneCode->setCode($code);
        $phoneCode->save();
    }

    private function send($phone){
        if(XConfig::get(XConfig::$phone_code_type)=="alidayu"){
            return  $this->sendAlidayu($phone);
        }else{
            return $this->sendByUrl($phone);
        }
    }

    /**
     * 使用阿里大鱼的验证码
     * @param $phone
     * @return int
     */
    private function sendAlidayu($phone){
        return 1111;
    }

    /**
     * 通过路劲发送验证码
     * @param $phone
     * @return mixed
     * @throws Exception  验证码发送失败
     */
    private function sendByUrl($phone){
        $url= XConfig::get(XConfig::$phone_code_url);
        $key= XConfig::get(XConfig::$phone_code_url_key);
        $ret=Http::get($url)->param("phone",$phone)->param("key",$key)->json();
        if($ret&&$ret["code"]){
             return $ret["code"];
        }
        throw  new Exception(ResultMsg::phone_code_send_error);
    }

    /**
     * 验证码验证
     * @param $phone
     * @param $type
     * @param $code
     * @return bool
     * @throws Exception
     */
    public function validateCode($phone,$type,$code){
        /* @var $phoneCode PhoneCode  */
        $phoneCode=PhoneCode::where(["phone"=>$phone,"type"=>$type,"status"=>0])
            ->order("create_time","desc")->find();
        if(!$phoneCode) throw  new Exception(ResultMsg::phone_code_not_exits);
        if($phoneCode->getCode()!=$code) throw  new Exception(ResultMsg::phone_code_error);
        $time=$phoneCode->getCreateTime();
        if(time()-$time>60000){
            throw  new Exception(ResultMsg::phone_code_expire);
        }
        $phoneCode->setStatus(1);
        $phoneCode->save();
        return true;
    }

}