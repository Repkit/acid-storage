<?php

/**
 * Storage object
 *
 * @package    Storage
 * @author     Repkit <repkit@gmail.com>
 * @copyright  2015 Repkit
 * @license    MIT <http://opensource.org/licenses/MIT>
 * @since      2015-08-17
 */

namespace acid\storage;

require 'Exceptions.php';
require 'utils.php';

class Storage
{
	protected $_config;
	private $_id;
	private $_path;
	protected $Id;

	public function __construct($Id)
	{
		$this->Id = $Id;
		$this->_id = session_id().$Id;
		$this->init();
	}

	public function read($Index = -1, $Length = -1)
	{
		$storage = fopen($this->_path, 'rb');
		$lock = flock($storage, LOCK_EX);
		if (!$lock) {
	        fclose($storage);
	        throw new StorageException('Error locking storage');
	    }

	    $data = stream_get_contents($storage, intval($Length), intval($Index));
	    if ($data === false) {
	        flock($storage, LOCK_UN);
	        fclose($storage);
	        throw new StorageException('Error reading storage');
	    }

	    flock($storage, LOCK_UN);
	    fclose($storage);

	    return $data;
	}

	public function write($Data, $Index = null)
	{
		if(!isset($Data) || !is_scalar($Data)){
			throw new StorageException("Error writing storage. Invalid data provided", 1);
		}

		$flag = SEEK_SET;
		if(!isset($Index)){
			$flag = SEEK_END;
		}

		$idx = intval($Index);

		$storage = fopen($this->_path, 'cb');
		fseek($storage, $idx, $flag);

		if($flag === SEEK_END){
			$idx = ftell($storage);
		}

		$written = fwrite($storage, $Data);

		$pos = ftell($storage);

		fclose($storage);

		return array('idx' => $idx, 'size' => $written, 'current' => $pos);
	}

	/**
	* Return info about the file using stat function
	* @link http://php.net/manual/en/function.stat.php
	*/
	public function info()
	{
		clearstatcache();
		return stat($this->_path);
	}

	public function clear($Index = null)
	{
		$idx = intval($Index);
		if($idx < 1){
			$storage = fopen($this->_path, 'w');
			fclose($storage);	
		}else{
			throw new StorageException("The option to truncate from an index is not yet implemented", 1);
		}

		return true;
	}

	private function init()
	{
		$config = $this->loadConfig();
		$this->_path = $config['storage_settings']['working_dir'].'/'.$this->_id;
		if(!createFile($this->_path) || !file_exists($this->_path)){
			throw new StorageException("Can't create storage");
		}

		return true;
	}

	private function loadConfig()
	{
		return $this->_config = require 'storage.config.php';
	}


}