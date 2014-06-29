<?php
/**
 * Part of Component Remoteimage files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Remoteimage\Provider;

use Joomla\DI\Container;
use Windwalker\DI\ServiceProvider;

// No direct access
defined('_JEXEC') or die;

/**
 * Remoteimage provider.
 *
 * @since 1.0
 */
class RemoteimageProvider extends ServiceProvider
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container $container The DI container.
	 *
	 * @return  Container  Returns itself to support chaining.
	 */
	public function register(Container $container)
	{
	}
}
