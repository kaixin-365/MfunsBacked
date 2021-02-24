<?php
namespace app\system\VideoInterface;
/*
 * @Author: your name
 * @Date: 2021-02-21 23:37:57
 * @LastEditTime: 2021-02-24 13:52:44
 * @LastEditors: Please set LastEditors
 * @Description: 视频类
 * @FilePath: \mfunstool\class\Interface\Video.class.php
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

   public static function getVideoInstance($size,$link,$title){
      return new self($size,$link,$title);
   }
 }