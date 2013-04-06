<?php

error_reporting(E_ALL); // Set E_ALL for debuging

include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderConnector.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinder.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeDriver.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeLocalFileSystem.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeFTP.class.php';
// Required for MySQL storage connector
// include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeMySQL.class.php';
// Required for FTP connector support
// include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeFTP.class.php';


/**
 * Simple function to demonstrate how to control file access using "accessControl" callback.
 * This method will disable accessing files/folders starting from  '.' (dot)
 *
 * @param  string  $attr  attribute name (read|write|locked|hidden)
 * @param  string  $path  file path relative to volume root directory started with directory separator
 * @return bool|null
 **/
function access($attr, $path, $data, $volume) {
	return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
		? !($attr == 'read' || $attr == 'write')    // set read+write to false, other (locked+hidden) set to true
		:  null;                                    // else elFinder decide it itself
}

$params = JComponentHelper::getParams('com_remoteimage') ;
$host = $params->get('Ftp_Host', '127.0.0.1') ;
$port = $params->get('Ftp_Port', 21) ;
$user = $params->get('Ftp_User') ;
$pass = $params->get('Ftp_Password') ;
$url = $params->get('Ftp_Url') ;
$root = $params->get('Ftp_Root', '/') ;

$opts = array(
	// 'debug' => true,
	'roots' => array(
		/*
		array(
			'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
			'path'          => JPATH_ROOT,         // path to files (REQUIRED)
			'URL'           => JURI::root(), // URL to files (REQUIRED)
			'accessControl' => 'access'             // disable and hide dot starting files (OPTIONAL)
		)
		,*/
		array(
			'driver'        => 'FTP',
			'host'          => $host,
			'user'          => $user,
			'pass'          => $pass,
			'port'          => $port,
			'mode'          => 'active',
			'path'          => $root,
			'timeout'       => 10,
			'owner'         => true,
			'tmbPath'       => JPATH_CACHE.'/thumbs/elfinder',
			'tmbURL'        => JURI::root() . 'cache/thumbs/elfinder',
			'tmp'			=> JPATH_ROOT . '/tmps',
			'dirMode'       => 0755,
			'fileMode'      => 0644,
			'URL'			=> $url,
			'debug'			=> true
		)
	)
);

// run elFinder
$connector = new elFinderConnector(new elFinder($opts));
$connector->run();

