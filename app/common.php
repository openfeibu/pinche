<?php
// +----------------------------------------------------------------------
/**
 * 批量判断空
 **/
function emptys($arr) {
    if (!is_array($arr)) {
        $arr = func_get_args();
    }
    foreach ($arr as $val) {
        if (empty($val)) {
            return 1;
        }
    }
    return 0;
}

function emptysThrow($arr) {
    if (!is_array($arr)) {
        $arr = func_get_args();
    }
      for($i=0;$i<count($arr);$i+=1){
          if(empty($arr[$i])){
              throw new Exception($arr[$i+1]);
          }
      }
    return 0;
}

/**
 * 统一化修改过的md5
 **/
function md5str($str) {
    return md5(md5("lykj") . $str . md5("duohuo"));
}


/**
 * 获取对象的方法参数
 **/
function getMethodParams($obj, $method, $vals) {
    $method = new \ReflectionMethod(get_class($obj), $method);
    $params = $method->getParameters();
    $args = array();
    for ($i = 0; $i < count($vals); $i++) {
        $val = $vals[$i];
        $name = $params[$i]->getName();
        $args[$name] = $val;
    }
    return $args;
}

function is_assoc_array(&$array) {
    return array_values($array) === $array;
}

/**
 * pluck
 */
function array_pluck($array) {
    $args = func_get_args();
    $data = array();
    if (is_array($array) && is_assoc_array($array)) {
        $data = array();
        foreach ($array as $arr) {
            $item = array();
            for ($i = 1; $i < count($args); $i++) {
                $key = $args[$i];
                if (is_array($arr)) {
                    $item[$key] = $arr[$key];
                } else if (is_object($arr)) {
                    $item[$key] = $arr->$key;
                }
            }
            $data[] = $item;
        }
    } else {
        for ($i = 1; $i < count($args); $i++) {
            $key = $args[$i];
            if (is_array($array)) {
                $data[$key] = $array[$key];
            } else if (is_object($array)) {
                $data[$key] = $array->$key;
            }
        }
    }
    return $data;
}

/**
 * 数组转化为树形 转化后的数组包裹的是对象
 */
function array_tree($arr, $children = "children", $id = "id", $pid = "pid") {
    if (!$arr) return array();
    $arrlist = [];
    foreach ($arr as $key) {
        if (!$key[$pid]) $key[$pid] = 0;
        $arrlist[] = $key;
    }
    //indexBy
    $arrmap = array();
    foreach ($arrlist as $b) {
        $arrmap[$b->$id] = $b;
    }
    //groupBy
    $group = array();
    foreach ($arrlist as $k => $v) {
        $key = $v->$pid;
        if (!array_key_exists($key, $group)) $group[$key] = array();
        $group[$key][] = $v;
    }
    foreach ($group as $key => $value) {
        if ($value) {
              if(!array_key_exists($key,$arrmap)){
                  $arrmap[$key]=(object)[];
              }
                $model=$arrmap[$key];
            if($model instanceof \think\Model){
                $model->putExtra($children,$value);
            }else{
                $arrmap[$key]->$children = $value;
            }

        }
    }
    return $arrmap[0]->$children;
}


function array_replace_notnull($from, $to) {
    $args = func_get_args();
    $count = count($args);
    for ($i = 1; $i < $count; $i++) {
        $arg = $args[$i];
        foreach ($arg as $key => $value) {
            if ($value !== null) {
                if (is_array($from) || $from == null) {
                    $from[$key] = $value;
                } else if (is_object($from)) {
                    $from->$key = $value;
                }
            }
        }
    }
    return $from;
}



/**
 * groupBy
 */
function array_group_by($arrlist, $pid)
{
    $group = array();
    foreach ($arrlist as $k => $v) {
        $key = "";
        if (is_object($v)) {
            $key = $v->$pid;
        } else if (is_array($v)) {
            $key = $v[$pid];
        }
        if (!array_key_exists($key, $group)) $group[$key] = array();
        $group[$key][] = $v;
    }
    return $group;
}

/**
 * indexBy
 */
function array_index_by($arrlist, $id)
{
    $arrmap = array();
    foreach ($arrlist as $b) {
        if (is_object($b)) {
            $arrmap[$b->$id] = $b;
        } else if (is_array($b)) {
            $arrmap[$b[$id]] = $b;
        }
    }
    return $arrmap;
}
function array_pick($arrlist, $keys)
{
    if(is_array($arrlist)){
        $datas=[];
        foreach ($arrlist as $item) {
            $datas[]=array_pluck($item,$keys);
        }
        return $datas;
    }
    $data=[];
    foreach ($keys as $key) {
        $data[$key]=$arrlist[$key];
    }
    return $data;
}

function string_to_camel_case($str)
{
    $array = explode('_', $str);
    $result = '';
    foreach ($array as $value) {
        $result .= ucfirst($value);
    }
    return $result;
}

/**
 * 字符串开头
 * @param $str
 * @param $end
 * @return bool
 */
function string_start($str,$start){
    return strpos($str, $start) === 0;
}

/**
 * 字符串结尾
 * @param $str
 * @param $end
 * @return bool
 */
function string_end($str,$end){
    return substr($str, strlen($str)-1, strlen($end)) === $end;
}

function handle_idcard($id_number)
{
    return strlen($id_number) == 15 ? substr_replace($id_number,"******",6,6) : (strlen($id_number)==18 ? substr_replace($id_number,"******",8,6) : '');
}
function handle_phone($phone)
{
    return substr_replace($phone,"****",4,4);
}

require_once("wxpay/lib/WxPay.Api.php");
