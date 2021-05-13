<?php

namespace Classes;

class Connection
{
	function Connection()
	{
		return new \MysqliDb(array(
			'host' => 'localhost',
			'username' => 'root',
			'password' => '', 
			'db' => 'myvuedatabase',
			'port' => 3306,
			'prefix' => '',
			'charset' => 'utf8'
		));
	}
}
