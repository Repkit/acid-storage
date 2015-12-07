<?php

/**
 * Utils collection
 *
 * @category   Utils
 * @author     Repkit <repkit@gmail.com>
 * @copyright  2015 Repkit
 * @license    MIT <http://opensource.org/licenses/MIT>
 * @since      2015-08-17
 */

 function dump($data){
 	echo '<pre>';
 	print_r($data);
 	echo '</pre>';
 }

 /**
 * Create file and directory structure if necesary
 */
 function createFile($dir){
 	//create dir structure if necesary
    $parts = explode(DIRECTORY_SEPARATOR, $dir);
    $file = array_pop($parts);
    $dir = '';
    foreach($parts as $part)
        if(!is_dir($dir .= DIRECTORY_SEPARATOR.$part)) mkdir($dir);

    //create file
    $handle = fopen($dir.DIRECTORY_SEPARATOR.$file, 'cb');
    fclose($handle);

    return true;
}