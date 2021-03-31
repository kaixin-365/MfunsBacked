<?php
/*
 * @Author: ChenDoXiu
 * @Description: 视频列表类
 * @Date: 2021-03-11 19:08:27
 * @LastEditors: ChenDoXiu
 * @LastEditTime: 2021-03-31 21:23:09
 * @FilePath: \MfunsBacked\app\system\VideoInterface\PlayList.php
 */
namespace app\system\VideoInterface;

use think\facade\Config;
use app\system\VideoInterface\Video;

class PlayList
{
  //视频id
  var string $vid;
  //清晰度列表
  protected $lists = [];
  //有效期
  var int $expir;
  protected function __construct($vid,$expir){
    $this->vid = $vid;
    $this->expir = $expir;
  }
  /**
   * 将video添加进lists
   *
   * @param Video $v
   * @return void
   * @Author ChenDoXiu
   * @DateTime 2021-03-13 10:41:50
   */
  function addVideo(Video $v){
    $this->lists[] = $v;
  }
  /**
   * 获取播放lists
   *
   * @return Array
   * @Author ChenDoXiu
   * @DateTime 2021-03-13 10:40:58
   */
  function getLists(){
    return $this->lists;
  }
  /**
   * 获取视频列表实例
   *
   * @param string $vid
   * @param integer $expir
   * @return PlayList
   * @Author ChenDoXiu
   * @DateTime 2021-03-21 19:51:30
   */
  static function getPlayListInstance(string $vid,int $expir = 0){
    return new self($vid,$expir);
  }
  
  /** 
   * 根据视频大小排名获取视频
   *
   * @param integer $size
   * @return Video
   * @Author ChenDoXiu
   * @DateTime 2021-03-13 10:36:05
   */
  function getVideoBySize(int $size){
    //判断列表是否为空

    if (empty($this->lists)) {
      return Video::getInstance("0",Config::get("video.error.404"),"404");
    }

    usort($this->lists,fn($a,$b) => $a>$b);
    $leng = count($this->lists) - 1;
    $leng = $leng >= $size ? $size : $leng;
    return $this->lists[$leng];
  }
}
