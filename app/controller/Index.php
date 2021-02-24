<?php
/*
 * @Author: your name
 * @Date: 2021-02-23 19:28:11
 * @LastEditTime: 2021-02-24 14:28:54
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \think\app\controller\Index.php
 */
namespace app\controller;

use app\BaseController;
use app\VideoParse\Weibo;
use app\VideoParse\YouKu;

class Index extends BaseController
{
    public function youku($vid = "XNDc0ODIzMTE5Ng")
    {
        $yk = new YouKu();
        return redirect($yk->getPlaylist($vid)->getVideoBySize(5)->link);
    }
    public function weibo($vid = ""){
        $wb = new Weibo();
        return redirect($wb->getPlaylist($vid)->getVideoBySize(10)->link);
    }
}
