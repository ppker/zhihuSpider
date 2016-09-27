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

preg_match('#<span class="education item" title=["|\'](.*?)["|\']>#', $result, $out);

preg_match('#<p class="title">\s(.*?)\s</span>#', $result, $out);

var_dump($out);die;

$re = push_log([$result]);