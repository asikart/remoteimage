<?php
/**
 * Part of Windwalker project. 
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Windwalker\Component;

use Joomla\CMS\Access\Access;
use Joomla\CMS\Factory;
use Joomla\CMS\User\User;
use Windwalker\Helper\PathHelper;
use Windwalker\Object\BaseObject;
use Windwalker\System\ExtensionHelper;

/**
 * Component Helper class.
 *
 * @since 2.0
 */
abstract class ComponentHelper
{
	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param   User    $user       The user object.
	 * @param   string  $component  The component access file path, component base path or option name.
	 * @param   string  $assetName  The asset name
	 * @param   integer $categoryId The category ID.
	 * @param   integer $id         The item ID.
	 *
	 * @return  BaseObject
	 */
	public static function getActions(User $user, $component, $assetName, $categoryId = 0, $id = 0)
	{
		$result	= new BaseObject;

		// New rules: If path is access file
		$path = $component;

		if (!is_file($path))
		{
			// New rules: If path is component base path
			$path = $path . '/access.xml';
		}

		if (!is_file($path))
		{
			$path = PathHelper::getAdmin($component) . '/etc/access.xml';
		}

		if (!is_file($path))
		{
			$path = PathHelper::getAdmin($component) . '/access.xml';
		}

		if (!$id && !$categoryId)
		{
			$section = 'component';
		}
		elseif (!$id && $categoryId)
		{
			$section = 'category';
			$assetName .= '.category.' . $categoryId;
		}
		elseif ($id && !$categoryId)
		{
			$section = $assetName;
			$assetName .= '.' . $assetName . '.' . $id;
		}
		else
		{
			$section = $assetName;
			$assetName .= '.' . $assetName;
		}

		$actions = Access::getActionsFromFile($path, "/access/section[@name='" . $section . "']/");

		foreach ($actions as $action)
		{
			$result->set($action->name, $user->authorise($action->name, $assetName));
		}

		return $result;
	}

	/**
	 * Execute Component.
	 *
	 * @param string $option Component option name.
	 * @param string $client `admin` or `site`.
	 * @param array  $input  Input object.
	 *
	 * @return  mixed
	 */
	public static function executeComponent($option, $client = 'site', $input = array())
	{
		$element = ExtensionHelper::extractElement($option);
		$input = new \JInput($input);

		// Prevent class conflict
		class_alias('JString', 'Joomla\\String\\StringHelper');

		if (! defined('JPATH_COMPONENT_ADMINISTRATOR'))
		{
			define('JPATH_COMPONENT_ADMINISTRATOR', PathHelper::get($option, 'admin'));
			define('JPATH_COMPONENT_SITE', PathHelper::get($option, 'site'));
			define('JPATH_COMPONENT', PathHelper::get($option, $client));
		}

		$_SERVER['HTTP_HOST'] = 'windwalker';

		if ($client === 'admin')
		{
			$client = 'administrator';
		}

		$appClass = 'JApplication' . ucfirst($client);

		$console = Factory::$application;

		Factory::$application = $appClass::getInstance('site', $input);

		$class = ucfirst($element['name']) . 'Component';

		$component = new $class(ucfirst($element['name']), $input, Factory::$application);

		$result = $component->execute();

		Factory::$application = $console;

		return $result;
	}
}
