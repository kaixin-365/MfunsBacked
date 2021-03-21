<?php
namespace app\VideoParse;
/*
 * @Author: chendoxiu
 * @Date: 2021-02-24 13:04:45
 * @LastEditTime: 2021-03-21 20:24:52
 * @LastEditors: ChenDoXiu
 * @Description: In User Settings Edit
 * @FilePath: \MfunsBacked\app\VideoParse\Error.php
 */

use app\system\VideoInterface\Video;
use app\system\VideoInterface\PlayList;
use app\system\VideoInterface\VideoParseInterface;

class Error extends VideoParseInterface{
  function getPlaylist($data): PlayList
  {
      $list = PlayList::getPlayListInstance("404",60);
      $list->addVideo(Video::getInstance("100","/404.mp4","视频不存在"));
      return $list;
  }
}