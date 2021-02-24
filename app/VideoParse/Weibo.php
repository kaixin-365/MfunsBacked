<?php
namespace app\VideoParse;

/*
 * @Author: ChenDoxiu
 * @Date: 2021-02-24 13:02:57
 * @LastEditTime: 2021-02-24 14:25:02
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \think\app\VideoParse\Weibo.php
 */

use think\facade\Log;
use think\facade\Config;
use app\VideoParse\Error;
use app\system\VideoInterface\Video;
use app\system\VideoInterface\PlayList;
use app\system\VideoInterface\VideoParseInterface;

class Weibo implements VideoParseInterface
{

    public function getPlaylist($vid): PlayList
    {
        try {
          //dump($vid);
            $json = $this->getPlayJson($vid);
            //dump($list["data"]["Component_Play_Playinfo"]);
            $json = $json["data"]["Component_Play_Playinfo"]["urls"];
            if (!$json) {
                throw new \Exception("视频不存在");
            }

            $list = PlayList::getPlayListInstance($vid);
            foreach ($json as $key => $value) {
                $list->addVideo(Video::getVideoInstance($this->findNum($key),$value,$key));
            }
            return $list;
        } catch (\Throwable $th) {
          Log::write((string)$th);
          //dump($th);
          $e = new Error();
          return $e->getPlaylist(404);
        }
    }

    public function getPlayJson($vid = "")
    {
        $curl = curl_init();
        $post = urlencode('{"Component_Play_Playinfo":{"oid":"' . $vid . '"}}');
        $cookie = Config::get("video.weibo.user_cookie");
        curl_setopt_array($curl, array(
            CURLOPT_URL => Config::get("video.weibo.url"),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "data=$post",
            CURLOPT_HTTPHEADER => array(
                "accept: application/json, text/plain, */*",
                "accept-language: zh-CN,zh;q=0.9",
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "cookie: $cookie",
                "referer: https://h5.video.weibo.com/show/$vid",
                "user-agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Mobile Safari/537.36",
            ),
        ));
        return json_decode(curl_exec($curl), true);
    }

    protected function findNum($str):int
    {
        $str = trim($str);
        if (empty($str)) {return '';}
        $reg = '/(\d{3,4}(\.\d+)?)/is'; //匹配数字的正则表达式
        preg_match_all($reg, $str, $result);
        if (is_array($result) && !empty($result) && !empty($result[1]) && !empty($result[1][0])) {
            return (int)$result[1][0];
        }
        return 0;

    }

}
