<?php
/**
 * Created by PhpStorm.
 * Author: ZhiPeng
 * Date: 2016/9/27
 * Project: Cat Visual
 */

date_default_timezone_set("Asia/Shanghai");
function beep($process_name) {

    echo $process_name . " 我的进程PID是: " . getmypid() . " " . date("Y-m-d H:i:s") . " \n";
    sleep(1);
}

 // declare(ticks = 1);
pcntl_signal(SIGCHLD, "garbage");
echo "全局父进程开始, pid :" . getmypid() . " \n";
for ($i = 0; $i < 3; ++$i) {
    $pid = pcntl_fork();
    if (-1 == $pid) {
        die("cannot fork son proces");
    } elseif (0 < $pid) {
        echo "父进程 执行 \n";
        for ($k = 0; $k < 2; ++$k) {
            beep("父进程");
        }
    } elseif (0 == $pid) {
        echo "子进程 执行 PID:" . getmypid() . " \n";
        for ($j = 0; $j < 5; ++$j) {
            beep("子进程" . getmypid());
        }
        exit(0); // 释放子进程
    }
}


while(1) {
    sleep(5);
    pcntl_signal_dispatch();
}

function garbage($signal) {
    echo "signal receive: " . $signal . " \n";
    while(($pid = pcntl_waitpid(-1, $status, WNOHANG)) > 0 ) {
        echo "子进程结束PID: " . $pid . " status: " . $status . " \n";
    }
}