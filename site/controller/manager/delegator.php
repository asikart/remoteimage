<?php
/**
 * Part of Component Remoteimage files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Windwalker\Controller\Resolver\ControllerDelegator;

// No direct access
defined('_JEXEC') or die;

/**
 * Remoteimage Manager delegator.
 *
 * @since 1.0
 */
class RemoteimageControllerManagerDelegator extends ControllerDelegator
{
	/**
	 * Register aliases.
	 *
	 * @return  void
	 */
	protected function registerAliases()
	{
	}

	/**
	 * Create Controller.
	 *
	 * @param   string $class Controller class name.
	 *
	 * @return  \Windwalker\Controller\Controller Controller instance.
	 */
	protected function createController($class)
	{
		$this->config['allow_url_params'] = array(
			'type'
		);

		return parent::createController($class);
	}
}
