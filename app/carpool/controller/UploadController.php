<?php
/**
 * Created by PhpStorm.
 * User: Xsx
 * Date: 2017/1/4
 * Time: 14:04
 */

namespace app\carpool\controller;


use app\core\base\BaseController;
use app\core\comp\Result;
use app\core\ImageUtil;
use think\Exception;
use think\File;
use think\Request;

class UploadController extends BaseController {

    public function uploadPic($filename = 'file', $type = 'img') {
        $request = Request::instance();
        $file = $request -> file($filename);
        if(empty($file)) {
            return Result::error('10001', '请选择上传文件');
        }
        $allow_max_size = 5000000;//默认图片上传最大限制 5M;
        $extension = strtolower(pathinfo($file->getInfo('name'), PATHINFO_EXTENSION));//获取文件的后缀，校验是否为图片类型
        if (!ImageUtil::checkIsImage($extension)) {
            throw new Exception('非法图片类型');
        }
        if (!$file->checkSize($allow_max_size)) {
            throw new Exception('图片大小超出最大图片限制');
        }
        $filePath = '/public' . DS . 'uploads';
        if ($type) {
            if (strpos($type, '.') != false) {
                throw new Exception('图片自定义路径错误');
            }
            $filePath .= DS . $type;
        }
        $file->rule('date');
        /* @var $file File  */
        $file = $file->move(ROOT_PATH . $filePath);
        $rs_path = str_replace(DS, '/', $filePath) . '/' . date('Ymd') . '/' . $file->getFilename();
        return Result::data($rs_path);
    }

}