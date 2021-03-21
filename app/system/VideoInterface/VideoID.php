<?php

namespace app\system\VideoInterface;
/*
 * @Author: ChenDoXiu
 * @Description: 
 * @Date: 2021-03-21 17:20:00
 * @LastEditors: ChenDoXiu
 * @LastEditTime: 2021-03-21 18:06:22
 * @FilePath: \MfunsBacked\app\system\VideoInterface\VideoID.php
 */

class VideoID
{
  // 视频id
  public string $vid;
  //分p
  public int $p;
  //类型
  public string $type;
  public function __construct(string $type,string $vid,int $p){
    $this->vid = $vid;
    $this->p = $p;
    $this->type = $type;
  }
  //获取实例
  public static function getInstance(string $type,string $vid,int $p):VideoID{
    return new self($type,$vid,$p);
  }

}
