<?php
namespace app\VideoParse;

/*
 * @Author: ChenDoxiu
 * @Date: 2021-02-24 13:02:57
 * @LastEditTime: 2021-03-22 07:26:03
 * @LastEditors: ChenDoXiu
 * @Description: In User Settings Edit
 * @FilePath: \MfunsBacked\app\VideoParse\Weibo.php
 */

use think\facade\Log;
use think\facade\Config;
use app\VideoParse\Error;
use app\system\VideoInterface\Video;
use app\system\VideoInterface\PlayList;
use app\system\VideoInterface\VideoParseInterface;

class Weibo extends VideoParseInterface
{

    public function getPlaylist($vid): PlayList
    {
        try {
            //dump($vid);
            $jsonall = $this->getPlayJson($vid->vid);
            //dump($jsonall);
            $json = $jsonall["data"]["Component_Play_Playinfo"]["urls"];
            if (!$json) {
                throw new \Exception("视频不存在");
            }
            //$title = $jsonall["data"]["Component_Play_Playinfo"]["title"];
            $title = "";
            $list = PlayList::getPlayListInstance($vid->vid,$this->getExpire(current($json)));
            foreach ($json as $key => $value) {
                $list->addVideo(Video::getInstance($this->findNum($key),$value,$title));
            }
            return $list;
        } catch (\Throwable $th) {
          Log::write((string)$th);
          //dump($th);
          $e = new Error();
          return $e->getPlaylist($vid);
        }
    }
    protected function getExpire($url){
      preg_match("/(?<=Expires=)\d+/",$url,$matches);
      return $matches[0] - time();
    }

    public function getPlayJson($vid)
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
        $txt = curl_exec($curl);
        return json_decode($txt, true);
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
