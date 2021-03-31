<?php
namespace app\VideoParse;
/*
 * @Author: chendoxiu
 * @Date: 2021-02-24 13:04:45
 * @LastEditTime: 2021-03-31 21:18:58
 * @LastEditors: ChenDoXiu
 * @Description: In User Settings Edit
 * @FilePath: \MfunsBacked\app\VideoParse\Error.php
 */

use app\system\VideoInterface\Video;
use app\system\VideoInterface\PlayList;
use app\system\VideoInterface\VideoParseInterface;
use think\facade\Config;

class Error extends VideoParseInterface{
  function getPlaylist($data): PlayList
  {
      $list = PlayList::getPlayListInstance("404",60);
      $list->addVideo(Video::getInstance("100",Config::get("video.error.404"),"视频不存在"));
      return $list;
  }
}