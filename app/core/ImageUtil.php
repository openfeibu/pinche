<?php
/**
 * 南京灵衍信息科技有限公司
 * User: jinghao@duohuo.net
 * Date: 16/10/26
 * Time: 下午9:26
 */

namespace app\core;


class ImageUtil {
    public static function checkIsImage($extension){
        return in_array($extension,["jpg","jpeg","png"]);
    }

}