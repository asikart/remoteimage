<?php
/**
 * Part of Component Remoteimage files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Remoteimage\Router;

use Windwalker\Router\Route as WindwalkerRoute;

// No direct access
defined('_JEXEC') or die;

/**
 * Remoteimage route.
 *
 * @since 1.0
 */
class Route extends WindwalkerRoute
{
	/**
	 * Build by resource.
	 *
	 * @param   string   $resource The resource key to find our route.
	 * @param   array    $data     The url query data.
	 * @param   boolean  $xhtml    Replace & by &amp; for XML compilance.
	 * @param   integer  $ssl      Secure state for the resolved URI.
	 *                             1: Make URI secure using global secure site URI.
	 *                             2: Make URI unsecure using the global unsecure site URI.
	 *
	 * @return  string Route url.
	 */
	public static function _($resource, $data = array(), $xhtml = true, $ssl = null)
	{
		if (strpos($resource, '.') === false)
		{
			$resource = 'com_remoteimage.' . $resource;
		}

		return parent::_($resource, $data, $xhtml, $ssl);
	}
}
