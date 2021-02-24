<?php
namespace app\controller;
/*
 * @Author: your name
 * @Date: 2021-02-24 10:52:39
 * @LastEditTime: 2021-02-24 13:39:56
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \think\app\controller\test.php
 */
class Test
{
    public function index()
    {
        $curl = curl_init();


        urlencode('{"Component_Play_Playinfo":{"oid":"1034:4607564709560327"}}');
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://h5.video.weibo.com/api/component",
            CURLOPT_RETURNTRANSFER => true,
            //CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "data=%7B%22Component_Play_Playinfo%22%3A%7B%22oid%22%3A%221034%3A4607564709560327%22%7D%7D",
            CURLOPT_HTTPHEADER => array(
                "accept: application/json, text/plain, */*",
                "accept-language: zh-CN,zh;q=0.9",
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "cookie: SINAGLOBAL=8760495364797.231.1614087751500;  wvr=6; webim_unReadCount=%7B%22time%22%3A1614095227794%2C%22dm_pub_total%22%3A0%2C%22chat_group_client%22%3A0%2C%22chat_group_notice%22%3A0%2C%22allcountNum%22%3A24%2C%22msgbox%22%3A0%7D; TC-V-WEIBO-G0=b09171a17b2b5a470c42e2f713edace0; SCF=AoJW_1Rl2fKroaUAkqMIWNVxt4jsJgivJnNW4fmvpTlVxAph_7-0GkPdunWXxO9nfXSP6JRCZUdPFP_8xKlEtuA.; SUB=_2A25NMacODeRhGeFL7VQS9inNzD-IHXVuRp_GrDV8PUJbmtAKLRHRkW9NfcSl7kHMXLCiitowaN5rMRxn6lE8ScOH; SUBP=0033WrSXqPxfM725Ws9jqgMF55529P9D9W5ng2L2psrgj.gXo8gcCpLi5JpX5K-hUgL.FoMfSoq0SoMpS0e2dJLoI7LhIsHVxsvqIP-t; ALF=1645676777; SSOLoginState=1614141278; _s_tentry=weibo.com; Apache=7523115174876.995.1614141429150; ULV=1614141430223:2:2:2:7523115174876.995.1614141429150:1614087751587",
                "referer: https://h5.video.weibo.com/show/1034:4607564709560327",
                "user-agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Mobile Safari/537.36",
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        dump(json_decode($response, true));
    }
}
