<?php
namespace app\system\VideoInterface;
/*
 * @Author: your name
 * @Date: 2021-02-21 21:51:11
 * @LastEditTime: 2021-03-21 20:55:59
 * @LastEditors: ChenDoXiu
 * @Description: 视频解析接口
 * @FilePath: \MfunsBacked\app\system\VideoInterface\VideoParseInterface.php
 */

abstract class VideoParseInterface{
    /**
     * 根据视频信息获取播放列表
     *
     * @param VideoID $data
     * @return PlayList
     * @Author ChenDoXiu
     * @DateTime 2021-03-13 10:46:17
     */
    abstract function getPlaylist(VideoID $vid):PlayList;
    /**
     * 获取视频信息播放列表（缓存模式）
     *
     * @param VideoID $vid
     * @return PlayList
     * @Author ChenDoXiu
     * @DateTime 2021-03-21 20:14:19
     */
    public function getPlayListUseCache(VideoID $vid):PlayList
    {
        if ($playList = VideoLinkCache::getCache($vid)){
            return $playList;
        }else{
            $playList = $this->getPlaylist($vid);
            VideoLinkCache::setCache($vid,$playList);
            return $playList;
        }
    }
}