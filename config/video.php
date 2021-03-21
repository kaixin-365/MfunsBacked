<?php
/*
 * @Author: your name
 * @Date: 2021-02-23 19:48:36
 * @LastEditTime: 2021-03-21 22:04:46
 * @LastEditors: ChenDoXiu
 * @Description: In User Settings Edit
 * @FilePath: \MfunsBacked\config\video.php
 */
return [
  "youku" => [
    "appkey" => "24679788",
    "url"  => "http://acs.youku.com/h5/mtop.youku.play.ups.appinfo.get/1.1/?",
    "api" => "mtop.youku.play.ups.appinfo.get",
    // 优酷用户cookie 注意！！！
    // 请手动删除 cookie 中的 _m_h5_tk 字段，否则可能导致解析无法使用
    //"user_cookie" => ""
    "user_cookie" => 'cna=IRPEF5E/sBwCAa+Zhac97VAR; __ysuid=1608991363081QoW; __aysid=1613786430927MJF; UM_distinctid=177bd2ae727115-080aa5e653e40b-3a7e0a5e-4df28-177bd2ae7281ff; xlly_s=1; P_gck=NA%7CG4kESiqg9l985yuIaDq%2FsQ%3D%3D%7CNA%7C1613787476438; user_name=l%E5%B0%A4%E5%85%B6%E8%87%AA%E5%A6%82%E6%BB%B4%E5%A4%8F%E6%B4%9B%E8%92%82o; P_pck_rm=oqD6EwPN2940215c397d4bZBXaQpMa2Ytvh3MtGC%2FWT2Vi%2BOj%2B%2FGbxpUitqBLVuBTjoUA%2FbQ1MjqrGkakiJ5QFn4HtYKnCXNxROxsg%2FagWk45GqHj7iYkJUEg0i1doo5wvGcg3vBb6%2BCNOxJ8G1obI0Ei0%2F3tO6V11XDHA%3D%3D_V2; P_sck=eI3bKVekgVMxb%2Bu9EZay84UNw3G9VQoD8buMcQoYE4ADV24c4ErM3u7S0uEF2%2FDg4jLv3Cyt9c6Ry8Bh34daGUjnW8xw7FViTFP1ajUrGfwZUtvbcBuPxbvLafDCQqi%2BzAYOjGT6crvlxL77NXBaKQ%3D%3D; __ayft=1613830747268; __ayscnt=1; P_ck_ctl=107A578D7411986B874718F2323D7F39; __arycid=do-1-00; __arcms=do-1-00; modalFrequency={"UUID":"2"}; __ayvstp=18; __aysvstp=58; isg=BHBwrwYl5EJmwIeQWDXUQ8vZQTzCuVQDi7pBh2rBPkueJRHPEsqwkpNUeCtFyQzb; l=eBaUtrC4O8tCA--0BOfZnurza752IIRjcuPzaNbMiOCPOufB5AdFW6gblIL6CnFRh60JR35AqfWDBeYBV_C-nxvTOEFS1fDqn; tfstk=cikRBPGnhURlAbZxbbdcRcuQU3TGZb77J6acphvxZW09W4Wdi1DiBYtwAoZYsnC..; __arpvid=16138404619175qYAbP-1613840462034; __aypstp=41; __ayspstp=90'
  ],
  "weibo"=>[
    "url" => "http://h5.video.weibo.com/api/component?",
    "user_cookie" => ""
  ]
];
