<?php
class test{
	const key="key";
	static $value="a's value";
	static function a(){
		echo "hello world";
	}
}

$name="value";
test::a();
echo test::key;