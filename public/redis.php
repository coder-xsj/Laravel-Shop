<?php
/*
 * redis 连接测试
 */
$redis = new Redis();
$redis->connect('127.0.0.1',6379);
$redis->set('name','xushengjin');
echo $redis->get('name');
