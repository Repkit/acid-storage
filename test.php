<?php

/**
 * Exceptions container
 *
 * @category   Exceptions
 * @author     Repkit <repkit@gmail.com>
 * @copyright  2015 Repkit
 * @license    MIT <http://opensource.org/licenses/MIT>
 * @since      2015-08-17
 */

include 'Storage.php';
include 'utils.php';

error_reporting(-1);
ini_set('display_errors',1);

$storage = new Storage('cocorico');
$data = array('name' => 'Coco Rico', 'age' => 21, 'sex' => 'male');
$res = $storage->write(json_encode($data));

dump($res);
