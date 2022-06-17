<?php
class Autoloader
{
	public static function Register()
	{
		return spl_autoload_register(['Autoloader', 'APP_Load']);
	}
	public static function underscore($camelCasedWord)
	{
		return strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $camelCasedWord));
	}
	public static function APP_Load($class_name)
	{
		if (class_exists($class_name)) {
			return false;
		}
		if (substr($class_name, 0, 4) == 'cls_') {
			$class_name = str_replace('cls_', '', $class_name);
		}
		$class = Autoloader::underscore($class_name);
		if (file_exists(APPROOT . "lib/class/{$class}.class.php")) {
			$pObjectFilePath = APPROOT . "lib/class/{$class}.class.php";
		}
		if ((file_exists($pObjectFilePath) === false) || (is_readable($pObjectFilePath) === false)) {
			die(json_encode([
				'STATUS'    => 'CLASS_NOT_FOUND',
				'CODE'      => 500,
				'MESSAGE'   => "Class \"{$class_name}\" not found file \"{$class}.class.php\""
			]));
		}
		require_once($pObjectFilePath);
	}
}
