<?php
/*
 * @Author: your name
 * @Date: 2021-02-23 19:28:11
 * @LastEditTime: 2021-02-24 14:45:32
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \FunsNew\think\route\app.php
 */
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::rule('v1/youku/[:vid]', 'index/youku');
Route::rule('v1/weibo/[:vid]', 'index/weibo');
Route::miss(function() {
  return '404 Not Found!';
});
