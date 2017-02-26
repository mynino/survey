<?php
namespace nino\Services;
/**
* 
*/
class DataService
{
	public $data; 
	function __construct()
	{
		$data=file_get_contents("php://input");
		$data=json_decode($data);
		$this->data=$data;
	}
	function data(){
		return $this->data;
	}
	function get($key){
		return isset($this->data->$key)?$this->data->$key:null;
	}
}