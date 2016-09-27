<?php
/**
 * Created by PhpStorm.
 * Author: ZhiPeng
 * Date: 2016/9/26
 * Project: Cat Visual
 */
require_once './spider/user.php';
require_once './function.php';
require_once './spider/curl.php';
require_once './spider/pdo_mysql.php';
require_once './spider/predis.php';
require_once './spider/log.php';

$result = Curl::request('GET', 'https://www.zhihu.com/people/hahha/about');
var_dump($result);die;
