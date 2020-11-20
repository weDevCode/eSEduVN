<?php
	if(!defined('isSet')){
		die('<h1>Truy cập trực tiếp bị cấm!</h1>');
	}
	// Cấu hình CSDL
	define('DB_HOST', 'localhost');
	define('DB_PORT', 3306);
	define('DB_NAME', 'eseduvn');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_TABLE_PREFIX', 'eseduvn_');

	// Cấu hình trang
	define('AUTHOR', 'eSEduVN');

	define('isInstalled', 1);