<?php
/*
 * @Author: ChenDoXiu
 * @Description:
 * @Date: 2021-03-25 20:05:54
 * @LastEditors: ChenDoXiu
 * @LastEditTime: 2021-03-25 21:00:26
 * @FilePath: \MfunsBacked\app\VideoParse\BilibiliAv.php
 */
namespace app\VideoParse;

use think\facade\Log;
use think\facade\Config;
use app\VideoParse\Error;
use app\system\VideoInterface\Video;
use app\system\VideoInterface\VideoID;
use app\system\VideoInterface\PlayList;
use app\system\VideoInterface\VideoParseInterface;

class BilibiliAv extends VideoParseInterface
{
    public function getPlaylist(VideoID $vid): PlayList
    {
        try {
            $json = $this->getPlayJson($vid->vid, $vid->p);
            dump($json);
            //判断是否为视频
            if ($json["mode"] != "video") {
                throw new \Exception("视频不存在");
            }

            $json = $json["data"];
            $playlist = PlayList::getPlayListInstance($vid->vid, $this->getExpire($json[0]["parts"][0]["url"]));
            foreach ($json as $key => $value) {
                dump($value);
                if (isset($value["parts"])) {
                    $playlist->addVideo(Video::getInstance(10 - $key, $value["parts"][0]["url"], $value["info"]));
                }

                if (isset($value["url"])) {
                    $playlist->addVideo(Video::getInstance(10 - $key, $value["url"], $value["info"]));
                }

            }
            return $playlist;
        } catch (\Throwable $th) {
            Log::write((string) $th);
            //dump($th);
            $e = new Error();
            return $e->getPlaylist($vid);

        }
    }

    protected function getExpire($url)
    {
        preg_match("/(?<=deadline=)\d+/", $url, $matches);
        return $matches[0] - time();
    }
    public function getPlayJson($vid, $p = "")
    {
        $url = Config::get("video.bilibili.biliplus_api") . "av=" . $vid . "&page=" . $p;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            //关闭ssl认证
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array(
                "accept: application/json, text/plain, */*",
                "accept-language: zh-CN,zh;q=0.9",
                "cache-control: no-cache",
                "user-agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Mobile Safari/537.36",
            ),
        ));
        $txt = curl_exec($curl);
        dump($txt);
        return json_decode($txt, true);
    }
}
