<?php
/**
 * Part of Windwalker project. 
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Windwalker\System\Config;

/**
 * Config Interface
 *
 * @since 2.0
 */
interface ConfigInterface
{
	/**
	 * Get config from file. Will get from cache if has loaded.
	 *
	 * @return  mixed
	 */
	public static function getConfig();

	/**
	 * Get config file path.
	 *
	 * @return  string
	 */
	public static function getPath();
}
