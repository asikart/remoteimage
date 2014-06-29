<?php
/**
 * Part of Component Remoteimage files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

include_once JPATH_LIBRARIES . '/windwalker/src/init.php';

JLoader::registerPrefix('Remoteimage', JPATH_BASE . '/components/com_remoteimage');
JLoader::registerNamespace('Remoteimage', JPATH_ADMINISTRATOR . '/components/com_remoteimage/src');
JLoader::registerNamespace('Windwalker', __DIR__);
JLoader::register('RemoteimageComponent', JPATH_BASE . '/components/com_remoteimage/component.php');
