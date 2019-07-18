<?php
/**
 * 承德博智网络科技有限公司
 * User: service@cdbozhi.com
 * Date: 16/10/28
 * Time: 下午2:45
 */

namespace app\core;


class ResultMsg {

    const login_account_or_passord_error="账号或密码错误";
    const login_account_black="你的账号已被管理员拉黑,请联系管理员";
    const register_exits="用户账号已存在";
    const register_phone_exits="用户手机号已存在";
    const login_qq_or_wx_not_exits="请绑定你的用户信息";
    const login_qq_error="QQ登录信息获取失败,请稍后再试";
    const login_wx_error="微信登录信息获取失败,请稍后再试";
    const login_qq_appid_not_exits="QQ配置信息为空，请等待管理员配置";
    const login_account_or_passort_empty="账号密码不可为空";
    const login_qq_wx_nickname_require="用户昵称不可为空";

    const upload_image_type_not_support="图片格式不支持";

    const to_login="请先登录";

    const phone_code_send_exits="短信已发送,如果你没有收到请1分钟后进行尝试";
    const phone_code_send_error="验证码发送失败";
    const phone_code_not_exits="请先获取验证码";
    const phone_code_error="手机验证码错误";
    const phone_code_expire="验证码已过期";


//    $nickname,"昵称不可为空",$password,"密码不可为空",$code,"手机验证码不可为空",$phone,"手机号不可为空"
    const field_nickname="昵称";
    const field_password="密码";
    const field_phone_code="手机验证码";
    const field_phone="手机号";
    const valide_require="不可为空";


}