<?php
/**
 * @Author: huhuaquan
 * @Date:   2015-06-08 17:56:27
 * @Last Modified by:   huhuaquan
 * @Last Modified time: 2015-08-21 16:18:20
 */
return array(
    'mysql' => array(
        'host' => '192.168.20.107',
        'port' => 3306,
        'username' => 'root',
        'password' => '123456',
        'dbname' => 'zhihu',
        'charset' => 'utf8',
        'dsn' => 'mysql:host=192.168.20.107;port=3306;dbname=zhihu',
        'tbl_prefix' => 'zh_',
        'option' => array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 1,
        ),
    )
);
