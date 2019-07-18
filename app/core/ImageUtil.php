<?php
/**
 * 承德博智网络科技有限公司
 * User: service@cdbozhi.com
 * Date: 16/10/26
 * Time: 下午9:26
 */

namespace app\core;


class ImageUtil {
    public static function checkIsImage($extension){
        return in_array($extension,["jpg","jpeg","png"]);
    }

}