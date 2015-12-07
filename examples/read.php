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

error_reporting(-1);
ini_set('display_errors',1);

require '../vendor/autoload.php';

// init storage
$storage = new RpkAcidStorage\Storage('test');

//read container
$data = $storage->read();

dump(json_decode('['.str_replace('}{', '},{', $data).']'));

function dump($data){
 	echo '<pre>';
 	print_r($data);
 	echo '</pre>';
 }


