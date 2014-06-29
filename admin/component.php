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
 * Remoteimage Component
 *
 * @since 1.0
 */
final class RemoteimageComponent extends \Remoteimage\Component\RemoteimageComponent
{
	/**
	 * Default task name.
	 *
	 * @var string
	 */
	protected $defaultController = 'manager.display';

	/**
	 * Prepare hook of this component.
	 *
	 * Do some customize initialise through extending this method.
	 *
	 * @return void
	 */
	public function prepare()
	{
		parent::prepare();
	}
}
