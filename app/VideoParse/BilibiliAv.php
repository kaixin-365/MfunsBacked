<?php
/*
 * @Author: ChenDoXiu
 * @Description:
 * @Date: 2021-03-25 20:05:54
 * @LastEditors: ChenDoXiu
 * @LastEditTime: 2021-03-31 23:52:28
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
    public function getPlayList(VideoID $vid): PlayList
    {
        try {
            $token = $this->getToken();
            //dump($token);
            $link = $this->getPlayLink($token, $vid);
            $playlist = PlayList::getPlayListInstance($vid->vid, $this->getExpire($link));
            $playlist->addVideo(Video::getInstance(1080, $link, "bilibili"));
            return $playlist;
        } catch (\Throwable $th) {
            //dump($th);
            Log::write($th->getMessage());
            $e = new Error();
            return $e->getPlaylist($vid);
        }
    }

    protected function getToken()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://bilibili.syyhc.com/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            //关闭ssl认证
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            //获取头部
            CURLOPT_HEADER => 1,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);
        list($header, $body) = explode("\r\n\r\n", $response);

        $cookie = "";
        $header = explode(PHP_EOL, $header);
        for ($i = 0; $i < count($header); $i++) {
            if (strpos($header[$i], "Cookie")) {
                //提取 cookie
                $str = str_replace("Set-Cookie: ", "", $header[$i]);
                $str = substr($str, 0, strpos($str, ";"));
                $cookie .= $str . ";";
            }
        }
        preg_match('/(?<=name="csrf_token" type="hidden" value=")[^"]*/', $body, $tokens);
        return [
            "token" => $tokens[0],
            "cookie" => $cookie
        ];
    }

    protected function getExpire($url)
    {
        preg_match("/(?<=deadline=)\d+/", $url, $matches);
        return $matches[0] - time();
    }
    protected function getPlayLink(array $token, VideoID $vid)
    {
        $p = array(
            'url' => $vid->vid,
            'go' => '',
            'csrf_token' => $token["token"]
        );
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://bilibili.syyhc.com/parser",
            CURLOPT_RETURNTRANSFER => true,
            //   CURLOPT_MAXREDIRS => 10,
            //   CURLOPT_TIMEOUT => 30,
            //关闭ssl认证
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $p,
            CURLOPT_COOKIE => $token["cookie"],
            CURLOPT_HTTPHEADER => array(
                'Upgrade-Insecure-Requests' => '1',
                'Origin' => 'https=>//bilibili.syyhc.com',
                'Content-Type' => 'application/x-www-form-urlencoded',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.80 Safari/537.36 Edg/86.0.622.43',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                'Sec-Fetch-Site' => 'same-origin',
                'Sec-Fetch-Mode' => 'navigate',
                'Sec-Fetch-User' => '?1',
                'Sec-Fetch-Dest' => 'document',
                'Referer' => 'https=>//bilibili.syyhc.com/',
                'Accept-Language' => 'zh-CN,zh;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
            )
        ));
        $response = curl_exec($curl);
        preg_match('/(?<=source src=")[^"]*/', $response, $url);
        //转义html实体字符
        $url = htmlspecialchars_decode($url[0]);
        return $url;
    }
}
