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
 * Remoteimage Managers view
 *
 * @since 1.0
 */
class RemoteimageViewManagerHtml extends \Remoteimage\View\ManagerView
{
	/**
	 * prepareRender
	 *
	 * @return  void
	 *
	 * @throws Exception
	 */
	protected function prepareRender()
	{
		$app  = $this->container->get('app');
		$user = $this->container->get('user');

		if ($app->isSite() && !$user->authorise('frontend.access'))
		{
			throw new \Exception(JText::_('JGLOBAL_RESOURCE_NOT_FOUND'), 404);
		}

		parent::prepareRender();
	}
}
