<?php
/**
 * Created by PhpStorm.
 * Author: ZhiPeng
 * Date: 2016/9/28
 * Project: Cat Visual
 */

require_once './function.php';
require_once './spider/curl.php';
require_once './spider/pdo_mysql.php';

$result = Curl::request('GET', 'https://www.dianrong.com/feapi/plans');

var_dump(json_decode($result, true));die;