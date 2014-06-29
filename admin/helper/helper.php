<?php
/**
 * Part of Component Remoteimage files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Remoteimage helper.
 *
 * @since 1.0
 */
abstract class RemoteimageHelper
{
	/**
	 * Configure the Link bar.
	 *
	 * @param   string  $vName  The name of the active view.
	 *
	 * @return  void
	 */
	public static function addSubmenu($vName)
	{
		$app       = \JFactory::getApplication();
		$inflector = \JStringInflector::getInstance(true);

		// Add Category Menu Item
		if ($app->isAdmin())
		{
			JHtmlSidebar::addEntry(
				JText::_('JCATEGORY'),
				'index.php?option=com_categories&extension=com_remoteimage',
				($vName == 'categories')
			);
		}

		foreach (new \DirectoryIterator(JPATH_ADMINISTRATOR . '/components/com_remoteimage/view') as $folder)
		{
			if ($folder->isDir() && $inflector->isPlural($view = $folder->getBasename()))
			{
				JHtmlSidebar::addEntry(
					JText::sprintf(sprintf('COM_REMOTEIMAGE_%s_TITLE_LIST', strtoupper($folder))),
					'index.php?option=com_remoteimage&view=' . $view,
					($vName == $view)
				);
			}
		}

		$dispatcher = \JEventDispatcher::getInstance();
		$dispatcher->trigger('onAfterAddSubmenu', array('com_remoteimage', $vName));
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param   string  $option  Action option.
	 *
	 * @return  JObject
	 */
	public static function getActions($option = 'com_remoteimage')
	{
		$user   = JFactory::getUser();
		$result = new \JObject;

		$actions = array(
			'core.admin',
			'core.manage',
			'core.create',
			'core.edit',
			'core.edit.own',
			'core.edit.state',
			'core.delete'
		);

		foreach ($actions as $action)
		{
			$result->set($action, $user->authorise($action, $option));
		}

		return $result;
	}
}
