<?php
/**
 *      [Haidao] (C)2013-2099 Dmibox Science and technology co., LTD.
 *      This is NOT a freeware, use is subject to license terms
 *
 *     
 */
define('__APP__', '../../index.php');
$_GET['m'] = 'Pay';
$_GET['c'] = 'Notify';
$_filename = basename(__FILE__, '.php');
preg_match('/^api_([A-Za-z]+)_(\w*)/', $_filename, $matches);
$_GET['a'] = $matches[2];
$_GET['method'] = $matches[1];
require '../../index.php';