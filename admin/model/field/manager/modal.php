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
JForm::addFieldPath(WINDWALKER_SOURCE . '/Form/Fields');
JFormHelper::loadFieldClass('Modal');

/**
 * Supports a modal picker.
 */
class JFormFieldManager_Modal extends JFormFieldModal
{
	/**
	 * The form field type.
	 *
	 * @var string
	 * @since    1.6
	 */
	protected $type = 'Manager_Modal';

	/**
	 * List name.
	 *
	 * @var string
	 */
	protected $view_list = 'managers';

	/**
	 * Item name.
	 *
	 * @var string
	 */
	protected $view_item = 'manager';

	/**
	 * Extension name, eg: com_content.
	 *
	 * @var string
	 */
	protected $extension = 'com_remoteimage';

}
