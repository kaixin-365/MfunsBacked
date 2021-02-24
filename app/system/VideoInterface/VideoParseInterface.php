<?php
namespace app\system\VideoInterface;
/*
 * @Author: your name
 * @Date: 2021-02-21 21:51:11
 * @LastEditTime: 2021-02-23 19:41:28
 * @LastEditors: Please set LastEditors
 * @Description: 视频解析接口
 * @FilePath: \mfanstool\class\Interface\VideoInterface.calss.php
 */

interface VideoParseInterface{
    function getPlaylist($data):PlayList;
}