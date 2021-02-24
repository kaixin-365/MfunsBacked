<?php
namespace app\VideoParse;
/*
 * @Author: chendoxiu
 * @Date: 2021-02-24 13:04:45
 * @LastEditTime: 2021-02-24 13:13:07
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \think\app\VideoParse\Error.php
 */

use app\system\VideoInterface\Video;
use app\system\VideoInterface\PlayList;
use app\system\VideoInterface\VideoParseInterface;

class Error implements VideoParseInterface{
  function getPlaylist($data): PlayList
  {
      $list = PlayList::getPlayListInstance("404");
      $list->addVideo(Video::getVideoInstance("100","/404.mp4","视频不存在"));
      return $list;
  }
}