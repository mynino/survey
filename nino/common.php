<?php
function getData(){
	$data=file_get_contents("php://input");
	$data=json_decode($data);
	return $data;
}