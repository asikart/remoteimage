<?php
/**
 * Part of Component Remoteimage files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

include_once JPATH_COMPONENT_ADMINISTRATOR . '/src/init.php';

echo with(new RemoteimageComponent)->execute();
