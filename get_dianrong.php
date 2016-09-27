<?php
/**
 * Created by PhpStorm.
 * Author: ZhiPeng
 * Date: 2016/9/27
 * Project: Cat Visual
 */

require_once './spider/curl.php';

$result = Curl::request('GET', 'https://www.dianrong.com/market');
var_dump($result);die;