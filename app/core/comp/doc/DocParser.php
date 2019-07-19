<?php

/**
 * 南京灵衍信息科技有限公司
 * User: jinghao@duohuo.net
 * Date: 16/10/28
 * Time: 下午4:14
 */
namespace app\core\comp\doc;

class DocParser {

    /**
     * 解析方法文档
     * @param $doc
     * @return array
     */
    public static function parseMethod($doc){
        $doc=str_replace("/**","",$doc);
        $doc=str_replace("*/","",$doc);
        $doc=str_replace("*","",$doc);
        $lines=explode("\n",$doc);
        $line_count=count($lines);
        $des=[];
        $params=[];
        for ($i=0;$i<$line_count;$i++) {
            $line=trim($lines[$i]);
            if(empty($line))continue;
            if(!string_start($line,"@")){
                $des[]=$line;
            }
            if(string_start($line,"@param")){
                $params[]=static::parseParam($line);
            }
        }
        $type="POST";
        $name="";
        if(count($des)>0){
            $name=$des[0];
        }
        if(count($des)>1){
            $t=$des[1];
            $des= array_slice($des,1);
            if($t=="GET"||$t=="POST"){
                $type=$t;
                $des= array_slice($des,1);
            }
        }else{
            $des=[];
        }
        $data=[
            "name"=>$name,
            "params"=>$params,
            "type"=>$type,
            "des"=>$des
        ];
        return $data;

    }

    /**
     * 解析参数
     * @param $param
     * @return array
     */
    private static function parseParam($param){
        $param=str_replace("@param","",$param);
        $infos=explode(" ",$param);
        $texts=[];
        foreach ($infos as $info) {
            if(!empty($info)){
                if(count($texts)<3){
                    $texts[]=$info;
                }else{
                    $texts[2].=" ".$info;
                }
            }
        }
        return [
            "name"=>count($texts)>0?str_replace("$","",$texts[0]) :"",
            "type"=>count($texts)>1?$texts[1]:"",
            "des"=>count($texts)>2?$texts[2]:""
        ];

    }


}