<?php

namespace app\system\VideoInterface;

use think\facade\Cache;

/**
 * 视频链接信息缓存
 *
 * @Author ChenDoXiu
 * @DateTime 2021-03-21 18:02:22
 */
class VideoLinkCache{
    /**
     * 存储缓存信息
     *
     * @param VideoID $vid
     * @param PlayList $playList
     * @return void
     * @Author ChenDoXiu
     * @DateTime 2021-03-21 20:09:22
     */
    public static function setCache(VideoID $vid, PlayList $playList){
        cache(self::getCacheName($vid),$playList,$playList->expir);
    }

    public static function getCache(VideoID $vid){
        return cache(self::getCacheName($vid));
    }
    /**
     * 获取视频缓存名称
     *
     * @param VideoID $vid
     * @return srting
     * @Author ChenDoXiu
     * @DateTime 2021-03-21 18:08:44
     */
    protected static function getCacheName(VideoID $vid):string{
        return $vid->type . "." . $vid->vid . "." . $vid->p;
    }
}