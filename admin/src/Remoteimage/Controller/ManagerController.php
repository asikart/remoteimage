<?php
/**
 * Part of joomla3302 project.
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Remoteimage\Controller;

use Windwalker\Controller\Controller;

/**
 * Class ManagerController
 *
 * @since 1.0
 */
class ManagerController extends Controller
{
	/**
	 * Method to run this controller.
	 *
	 * @return  mixed
	 */
	protected function doExecute()
	{
		\JLoader::register('elFinderConnector', REMOTEIMAGE_ADMIN . '/src/Elfinder/elFinderConnector.class.php');
		\JLoader::register('elFinder', REMOTEIMAGE_ADMIN . '/src/Elfinder/elFinder.class.php');
		\JLoader::register('elFinderVolumeDriver', REMOTEIMAGE_ADMIN . '/src/Elfinder/elFinderVolumeDriver.class.php');
		\JLoader::register('elFinderVolumeLocalFileSystem', REMOTEIMAGE_ADMIN . '/src/Elfinder/elFinderVolumeLocalFileSystem.class.php');
		\JLoader::register('elFinderVolumeFTP', REMOTEIMAGE_ADMIN . '/src/Elfinder/elFinderVolumeFTP.class.php');

		// Required for MySQL storage connector
		// \JLoader::register('elFinderVolumeMySQL', REMOTEIMAGE_ADMIN . '/src/Elfinder/elFinderVolumeMySQL.class.php');
		// \JLoader::register('elFinderVolumeS3', REMOTEIMAGE_ADMIN . '/src/Elfinder/elFinderVolumeS3.class.php');

		/**
		 * Simple function to demonstrate how to control file access using "accessControl" callback.
		 * This method will disable accessing files/folders starting from  '.' (dot)
		 *
		 * @param  string $attr attribute name (read|write|locked|hidden)
		 * @param  string $path file path relative to volume root directory started with directory separator
		 *
		 * @return bool|null
		 **/
		function access($attr, $path, $data, $volume)
		{
			return strpos(basename($path), '.') === 0 // if file/folder begins with '.' (dot)
				? !($attr == 'read' || $attr == 'write') // set read+write to false, other (locked+hidden) set to true
				: null; // else elFinder decide it itself
		}

		$params     = \JComponentHelper::getParams('com_remoteimage');
		$safemode   = $params->get('Safemode', true);
		$host       = $params->get('Ftp_Host', '127.0.0.1');
		$port       = $params->get('Ftp_Port', 21);
		$user       = $params->get('Ftp_User');
		$pass       = $params->get('Ftp_Password');
		$active     = $params->get('Ftp_Active', 'passive');
		$url        = $params->get('Ftp_Url');
		$root       = $params->get('Ftp_Root', '/');
		$local_root = $params->get('Local_Root', 'images');

		$roots = array();

		if ($params->get('Connection_Local', 1))
		{
			$roots[] = array(
				'driver'        => 'LocalFileSystem',
				//'alias'         => $local_root,
				'path'          => JPATH_ROOT . '/' . trim($local_root, '/'),
				'URL'           => \JURI::root() . trim($local_root, '/'),
				'accessControl' => 'access',
				'uploadDeny'    => array('text/x-php'),
				'icon'          => \JURI::root() . 'administrator/components/com_remoteimage/includes/js/elfinder/img/volume_icon_local.png'
			);
		}

		if ($params->get('Connection_Ftp', 0))
		{
			$roots[] = array(
				'driver'          => 'FTP',
				'alias'           => $host,
				'host'            => $host,
				'user'            => $user,
				'pass'            => $pass,
				'port'            => $port,
				'mode'            => $active,
				'path'            => $root,
				'timeout'         => 10,
				'owner'           => true,
				'tmbPath'         => JPATH_ROOT . '/cache/elfinderThumbs',
				'tmbURL'          => \JURI::root() . '/cache/elfinderThumbs',
				'tmp'             => JPATH_ROOT . '/cache/elfinderTemps',
				'dirMode'         => 0755,
				'fileMode'        => 0644,
				'URL'             => $url,
				'checkSubfolders' => false,
				'uploadDeny'      => array('text/x-php'),
				'icon'            => \JURI::root() . 'administrator/components/com_remoteimage/includes/js/elfinder/img/volume_icon_ftp.png'
			);
		}

		// Safe Mode
		if ($safemode)
		{
			foreach ($roots as &$root):
				$root['disabled'] = array('archive', 'extract', 'rename', 'mkfile');
			endforeach;
		}

		$opts = array(
			// 'debug' => true,
			'roots' => $roots
		);

		// Run elFinder
		$connector = new \elFinderConnector(new \elFinder($opts));
		$connector->run();

		exit();
	}
}
