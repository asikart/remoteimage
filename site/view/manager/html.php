<?php
/**
 * Part of Component Remoteimage files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Remoteimage\Router\Route;
use Joomla\Registry\Registry;
use Windwalker\Data\Data;
use Windwalker\Helper\DateHelper;
use Windwalker\View\Html\ItemHtmlView;

// No direct access
defined('_JEXEC') or die;

/**
 * Remoteimage Managers view
 *
 * @since 1.0
 */
class RemoteimageViewManagerHtml extends ItemHtmlView
{
	/**
	 * The component prefix.
	 *
	 * @var  string
	 */
	protected $prefix = 'remoteimage';

	/**
	 * The component option name.
	 *
	 * @var string
	 */
	protected $option = 'com_remoteimage';

	/**
	 * The text prefix for translate.
	 *
	 * @var  string
	 */
	protected $textPrefix = 'COM_REMOTEIMAGE';

	/**
	 * The item name.
	 *
	 * @var  string
	 */
	protected $name = 'manager';

	/**
	 * The item name.
	 *
	 * @var  string
	 */
	protected $viewItem = 'manager';

	/**
	 * The list name.
	 *
	 * @var  string
	 */
	protected $viewList = 'managers';

	/**
	 * Prepare data hook.
	 *
	 * @return  void
	 */
	protected function prepareData()
	{
		$data = $this->getData();
		$user = $this->container->get('user');

		$data->category = $this->get('Category');
		$data->params   = $this->get('Params');

		// Prepare setting data
		$item = $data->item = new Data($data->item);

		// Link
		// =====================================================================================
		$query = array(
			'id'    => $item->id,
			'alias' => $item->alias,
			// 'catid' => $item->catid
		);
		$item->link = Route::_('com_remoteimage.manager', $query);

		// Dsplay Data
		// =====================================================================================
		$item->created_user = JFactory::getUser($item->created_by)->get('name');
		$item->cat_title = !empty($this->category) ? $this->category->title : null;

		if ($item->modified == '0000-00-00 00:00:00')
		{
			$item->modified = '';
		}

		// View Level
		// =====================================================================================
		if ($access = $data->state->get('filter.access'))
		{
			// If the access filter has been set, we already know this user can view.
			$data->params->set('access-view', true);
		}
		else
		{
			// If no access filter is set, the layout takes some responsibility for display of limited information.
			$user   = JFactory::getUser();
			$groups = $user->getAuthorisedViewLevels();

			if (!$item->catid || empty($this->category->access))
			{
				$data->params->set('access-view', in_array($item->access, $groups));
			}
			else
			{
				$data->params->set('access-view', in_array($item->access, $groups) && in_array($this->category->access, $groups));
			}
		}

		// Publish Date
		// =====================================================================================
		$pup  = DateHelper::getDate($item->publish_up)->toUnix(true);
		$pdw  = DateHelper::getDate($item->publish_down)->toUnix(true);
		$now  = DateHelper::getDate('now')->toUnix(true);
		$null = DateHelper::getDate('0000-00-00 00:00:00')->toUnix(true);

		if (($now < $pup && $pup != $null) || ($now > $pdw && $pdw != $null))
		{
			$item->published = 0;
		}

		$this->prepareEvents($item);

		$this->configureParams($item);
	}

	/**
	 * Prepare the content events.
	 *
	 * @param Data $item The item object.
	 *
	 * @return  void
	 */
	protected function prepareEvents($item)
	{
		$data = $this->getData();

		// Plugins
		// =====================================================================================
		$item->event = new stdClass;

		$dispatcher = $this->container->get('event.dispatcher');
		JPluginHelper::importPlugin('content');

		$item->text = $item->introtext . $item->fulltext;
		$results = $dispatcher->trigger('onContentPrepare', array('com_remoteimage.manager', &$item, &$data->params, 0));

		$results = $dispatcher->trigger('onContentAfterTitle', array('com_remoteimage.manager', &$item, &$data->params, 0));
		$item->event->afterDisplayTitle = trim(implode("\n", $results));

		$results = $dispatcher->trigger('onContentBeforeDisplay', array('com_remoteimage.manager', &$item, &$data->params, 0));
		$item->event->beforeDisplayContent = trim(implode("\n", $results));

		$results = $dispatcher->trigger('onContentAfterDisplay', array('com_remoteimage.manager', &$item, &$data->params, 0));
		$item->event->afterDisplayContent = trim(implode("\n", $results));
	}

	/**
	 * Configure the config data.
	 *
	 * @param Data $item The item object
	 *
	 * @return  void
	 */
	protected function configureParams($item)
	{
		$app  = $this->container->get('app');
		$data = $this->getData();

		// Params
		// =====================================================================================

		// Merge manager params. If this is single-manager view, menu params override article params
		// Otherwise, manager params override menu item params
		$active       = $app->getMenu()->getActive();
		$temp         = clone ($data->params);
		$item->params = new Registry($item->params);

		// Check to see which parameters should take priority
		if ($active)
		{
			$currentLink = $active->link;

			// If the current view is the active item and an manager view for this manager,
			// then the menu item params take priority
			if (strpos($currentLink, 'view=manager') && (strpos($currentLink, '&id=' . (string) $item->id)))
			{
				// $item->params are the manager params, $temp are the menu item params
				// Merge so that the menu item params take priority
				$item->params->merge($temp);

				// Load layout from active query (in case it is an alternative menu item)
				if (isset($active->query['layout']))
				{
					$this->setLayout($active->query['layout']);
				}
			}
			else
			{
				// Current view is not a single manager, so the manager params take priority here
				// Merge the menu item params with the manager params so that the manager params take priority
				$temp->merge($item->params);
				$this->params = $temp;

				// Check for alternative layouts (since we are not in a single-manager menu item)
				// Single-manager menu item layout takes priority over alt layout for an manager
				if ($layout = $data->params->get('manager_layout'))
				{
					$this->setLayout($layout);
				}

				// If not Active, set Title
				$this->setTitle($item->get('title'));
			}
		}
		else
		{
			// Merge so that article params take priority
			$temp->merge($data->params);
			$this->params = $temp;

			// Check for alternative layouts (since we are not in a single-article menu item)
			// Single-article menu item layout takes priority over alt layout for an article
			if ($layout = $data->params->get('manager_layout'))
			{
				$this->setLayout($layout);
			}

			// If not Active, set Title
			$this->setTitle($item->get('title'));
		}

		$item->params = $data->params;
	}
}
