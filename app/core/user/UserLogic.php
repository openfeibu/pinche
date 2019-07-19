<?php
/**
 * 南京灵衍信息科技有限公司
 * User: jinghao@duohuo.net
 * Date: 16/10/19
 * Time: 下午2:03
 */
namespace app\core\user;

use think\Exception;

/**
 * 用户信息接口
 * Interface UserLogic
 * @package app\core\user
 */
interface UserLogic {

    /**
     * 用户登录
     * 返回示例:
     * {
     *       user_id:'(int)用户id',
     *       name:'用户昵称',
     *       head:'用户头像',
     *       score:'用户积分',
     *       group_name:'用户组',
     *       group_id:'用户组id',
     *       token:'用户对应的token'
     *    }
     * @param $nicknameOrPhone string 昵称或手机号
     * @param $password  string  密码
     * @throws Exception 账号或密码错误
     * @return mixed
     */
    public function login($nicknameOrPhone, $password);

    /**
     * 只使用手机号登录
     * @param $phone
     * @return mixed
     */
    public function phoneLogin($phone);


    /**
     * QQ登录 如果没有对应用户请注册新用户
     * 如果用户名重复请返回success:false,并带msg
     * 返回示例:
     * {
     *     user_id:'(int)用户id',
     *     name:'用户昵称',
     *     head:'用户头像',
     *     score:'用户积分',
     *     group_name:'用户组',
     *     group_id:'用户组id',
     *     token:'用户对应的token'
     *  }
     * @param $openid string $openid
     * @param $nickname string 用户昵称
     * @param $head     string 用户头像
     * @param $register boolean 没有用户时是否注册
     * @throws Exception 需要注册用户时用户昵称已存在 返回的code为200
     * @return mixed
     */
    public function qqLogin($openid, $nickname, $head, $register = false);

    /**
     * 将openid绑定到对应的用户上 如果openid已存在,会进行先解绑再绑定到新用户上
     * @param $openid  string QQ openid
     */
    public function qqBind($openid);

    /**
     * wx登录 如果没有对应用户请注册新用户
     * 如果用户名重复请返回success:false,并带msg
     * 返回示例:
     * {
     *     user_id:'(int)用户id',
     *     name:'用户昵称',
     *     head:'用户头像',
     *     score:'用户积分',
     *     group_name:'用户组',
     *     group_id:'用户组id',
     *     token:'用户对应的token'
     *  }
     * @param $unionid string 微信的unionid
     * @param $openid string 微信的openid
     * @param $nickname string 用户昵称
     * @param $head     string 用户头像
     * @param $register boolean 没有用户时是否注册
     * @throws Exception 需要注册用户时用户昵称已存在 返回的code为200
     * @return mixed
     */
    public function wxLogin($unionid, $openid, $nickname, $head, $register = false);

    /**
     * 将unionid和openid 如果已存在,会进行先解绑再绑定到新用户上
     * @param $unionid  string QQ openid
     * @param $openid  string QQ openid
     */
    public function wxBind($unionid, $openid);

    /**
     * 登出 等出后用户token失效
     */
    public function logout();

    /**
     * 用户注册
     * @param $nickname string 用户昵称
     * @param $phone    string 用户手机号
     * @param $password string 用户密码
     * @return int 用户id
     */
    public function register($nickname, $phone, $password);


    /**
     * 获取用户基本信息
     * 返回示例:
     * {
     *     user_id:'(int)用户id',
     *     name:'用户昵称',
     *     head:'用户头像',
     *     score:'用户积分',
     *     group_name:'用户组',
     *     group_id:'用户组id',
     *     token:'用户对应的token'
     *  }
     * @param $user_id
     * @return mixed
     */
    public function userBasic($user_id);

    /**
     *   获取用户的详细信息
     *   返回示例:
     * {
     *     user_id:'(int)用户id',
     *     name:'用户昵称',
     *     head:'用户头像',
     *     score:'用户积分',
     *     group_name:'用户组',
     *     group_id:'用户组id',
     *     token:'用户对应的token'
     *  }
     * @param $user_id
     * @return mixed
     */
    public function userDetail($user_id);

    /**
     * 更新用户头像
     * @param $path
     * @return string 用户头像地址
     */
    public function changUserHead($path);

    /**
     * 更新当前用户密码
     * @param $accountOrPhone  string 用户账号手机号
     * @param $password  string 新密码
     */
    public function changePassword($accountOrPhone, $password);

    /**
     * 绑定当前用户手机号
     * @param $user_id  int 用户id
     * @param $phone  string 用户手机
     */
    public function bindPhone($user_id, $phone);

    /**
     * 获取当前用户的消息数目
     * 获取不到返回false
     * 返回示例:
     * {
     *   pm:'私信数量',
     *   notice:'通知数量'
     * }
     * @return mixed
     */
    public function userNoticeCount();

    /**
     * 添加积分
     * @param $user_id int 用户id
     * @param $score string 积分信息{extcredits1:1,extcredits2:1}
     */
    public function scoreAdd($user_id, $score);

    /**
     * 积分配置
     * 返回信息:
     * {
     *   extcredits1:'威望',
     *   extcredits2:'金钱',
     *   extcredits3:'贡献'
     * }
     */
    public function scoreSetting();

    /**
     * 检查用户是否被拉黑
     * @return mixed
     */
    public function isBlack();

}