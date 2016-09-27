<?php
/**
 * Created by PhpStorm.
 * Author: ZhiPeng
 * Date: 2016/9/27
 * Project: Cat Visual
 */
require_once './function.php';
require_once './spider/curl.php';

$result = Curl::request('GET', 'https://www.dianrong.com/market');
$re = push_log([$result]);