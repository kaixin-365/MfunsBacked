<?php
namespace app\system\VideoInterface;
/*
 * @Author: your name
 * @Date: 2021-02-21 23:37:57
 * @LastEditTime: 2021-03-21 17:39:00
 * @LastEditors: ChenDoXiu
 * @Description: 视频类
 * @FilePath: \MfunsBacked\app\system\VideoInterface\Video.php
 */

 class Video{
   /**
    * @description: 视频尺寸
    */   
   var $size = 0;
   /**
    * @description: 视频链接
    */   
   var $link = "";
   /**
    * @description: 视频标题
    */   
   var $title = "";

   protected function __construct($s,$l,$t)
   {
     $this->size = $s;
     $this->link = $l;
     $this->title = $t;
   }
   /**
    * 获取video实例
    *
    * @param [type] $size
    * @param [type] $link
    * @param [type] $title
    * @return Video
    * @Author ChenDoXiu
    * @DateTime 2021-03-13 10:44:23
    */
   public static function getInstance($size,$link,$title){
      return new self($size,$link,$title);
   }
 }