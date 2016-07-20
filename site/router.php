<?php
/**
 * Part of Component Remoteimage files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

use Windwalker\Router\CmsRouter;
use Windwalker\Router\Helper\RoutingHelper;

include_once JPATH_ADMINISTRATOR . '/components/com_remoteimage/src/init.php';

// Prepare Router
$router = CmsRouter::getInstance('com_remoteimage');

// Register routing config and inject Router object into it.
$router = RoutingHelper::registerRouting($router, 'com_remoteimage');

if (!function_exists('RemoteimageBuildRoute'))
{
	/**
	 * RemoteimageBuildRoute
	 *
	 * @param array &$query
	 *
	 * @return  array
	 */
	function RemoteimageBuildRoute(&$query)
	{
		$segments = array();

		$router = CmsRouter::getInstance('com_remoteimage');

		$query = \Windwalker\Router\Route::build($query);

		if (!empty($query['view']))
		{
			$segments = $router->build($query['view'], $query);

			unset($query['view']);
		}

		return $segments;
	}
}

if (!function_exists('RemoteimageParseRoute'))
{
	/**
	 * RemoteimageParseRoute
	 *
	 * @param array $segments
	 *
	 * @return  array
	 */
	function RemoteimageParseRoute($segments)
	{
		$router = CmsRouter::getInstance('com_remoteimage');

		$segments = implode('/', $segments);

		// OK, let's fetch view name.
		$view = $router->getView(str_replace(':', '-', $segments));

		if ($view)
		{
			return array('view' => $view);
		}

		return array();
	}
}

if (class_exists('JComponentRouterBase'))
{
	class RemoteimageRouter extends JComponentRouterBase
	{
		/**
		 * Build method for URLs
		 * This method is meant to transform the query parameters into a more human
		 * readable form. It is only executed when SEF mode is switched on.
		 *
		 * @param   array &$query An array of URL arguments
		 *
		 * @return  array  The URL arguments to use to assemble the subsequent URL.
		 *
		 * @since   2.0.8
		 */
		public function build(&$query)
		{
			return RemoteimageBuildRoute($query);
		}

		/**
		 * Parse method for URLs
		 * This method is meant to transform the human readable URL back into
		 * query parameters. It is only executed when SEF mode is switched on.
		 *
		 * @param   array &$segments The segments of the URL to parse.
		 *
		 * @return  array  The URL attributes to be used by the application.
		 *
		 * @since   2.0.8
		 */
		public function parse(&$segments)
		{
			return RemoteimageParseRoute($segments);
		}
	}
}
