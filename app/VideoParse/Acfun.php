<?php

namespace app\VideoParse;

use think\facade\Log;
use app\VideoParse\Error;
use app\system\VideoInterface\Video;
use app\system\VideoInterface\VideoID;
use app\system\VideoInterface\PlayList;
use app\system\VideoInterface\VideoParseInterface;

/*
 * @Author: ChenDoXiu
 * @Description: 
 * @Date: 2021-04-15 20:46:37
 * @LastEditors: ChenDoXiu
 * @LastEditTime: 2021-04-16 21:13:56
 * @FilePath: \MfunsBacked\app\VideoParse\Acfun.php
 */

class Acfun extends VideoParseInterface
{
    public function getPlayList(VideoID $vid): PlayList
    {
        try {
            $list = $this->getPlayJson($vid);
            $playlist = PlayList::getPlayListInstance($vid->vid,21600);
            $title = $list["title"];
            foreach ($list["video"] as $value) {
                $playlist->addVideo(Video::getInstance($value["height"],$value["url"],$title));
            }
            return $playlist;
        } catch (\Throwable $th) {
            Log::write($th->getMessage());
            $e = new Error();
            return $e->getPlaylist($vid);
        }
    }

    private function getPlayJson(VideoID $vid)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.acfun.cn/v/{$vid->vid}_{$vid->p}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            //关闭ssl认证
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,

            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept-encoding: gzip, deflate, br",
                "accept-language: zh-CN,zh;q=0.9",
                "cache-control: no-cache",
                "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3724.8 Safari/537.36"
            ),
        ));

        $response = curl_exec($curl);
        //dump($response);
        preg_match('/(?<=window.videoInfo = )[^\n]+\}/', $response, $list);
        if (!empty($list)) {
            $json = json_decode($list[0],true);
            $title = $json["title"];
            $json = $json["currentVideoInfo"]["ksPlayJson"];
            $json =  json_decode($json,true);
            return [
                "title" => $title,
                "video" => $json["adaptationSet"][0]["representation"]
            ];
        } else {
            return false;
        }
        
        
    }
}
