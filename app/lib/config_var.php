<?php
if (stripos(__FILE__, 'config_var.php') === false) {
	die("Access denied!");
}

$document_root = '';
$arrDirectoryHierarchy = explode(DIRECTORY_SEPARATOR, getcwd());
$lastDir = '';
foreach ($arrDirectoryHierarchy as &$folder) {
	if (in_array($folder, ['lib', 'app'])) {
		break;
	} else {
		$document_root .= $folder . DIRECTORY_SEPARATOR;
	}
	$lastDir = $folder;
}

define('APPROOT', $document_root . 'app' . DIRECTORY_SEPARATOR);

// Ej: se usa para los includes
define('DOMAIN_ROOT', 'https://' . $_SERVER['SERVER_NAME'] . (!in_array($lastDir, ['app', 'core', 'public_html']) ? "/{$lastDir}/app/" : '/app/'));
