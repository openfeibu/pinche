<?php
/**
 * 南京灵衍信息科技有限公司
 * User: jinghao@duohuo.net
 * Date: 16/9/30
 * Time: 上午10:06
 */

namespace app\core\base;

use app\core\comp\Result;
use app\core\comp\UserHolder;
use think\db\Query;
use think\Model;

class BaseModel extends Model {

    /**
     * 从数组中合并数据
     * @param array $data
     */
    public function fromArray(array $data)
    {
        foreach ($data as $key => $val) {
            $methodName = "set" . string_to_camel_case($key);
            if (method_exists($this, $methodName)) {
                $this->$methodName($val);
            } else {
                $this->putExtra($key, $val);
            }
        }
    }




}