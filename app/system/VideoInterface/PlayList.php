<?php
namespace app\system\VideoInterface;

use app\system\VideoInterface\Video;
/*
 * @Author: your name
 * @Date: 2021-02-21 23:11:27
 * @LastEditTime: 2021-02-24 14:28:08
 * @LastEditors: Please set LastEditors
 * @Description: 视频列表类
 * @FilePath: \mfunstool\class\Interface\PlayList.class.php
 */
class PlayList
{
  var $vid;
  protected $lists = [];
  protected function __construct($vid){
    $this->vid = $vid;
  }
  function addVideo(Video $v){
    $this->lists[] = $v;
  }
  function getLists(){
    return $this->lists;
  }
  static function getPlayListInstance($vid){
    return new self($vid);
  }
  /**
   * @description: 根据视频大小排序后返回指定大小序号的视频，从1开始，找不到就向下取最近的
   * @param {*} int
   * @return {*}
   */  
  function getVideoBySize(int $size){
    usort($this->lists,fn($a,$b) => $a>$b);
    $leng = count($this->lists) - 1;
    $leng = $leng >= $size ? $size : $leng;
    return $this->lists[$leng];
  }
}
