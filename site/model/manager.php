<?php
/**
 * Part of Component Remoteimage files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Windwalker\Model\ItemModel;

// No direct access
defined('_JEXEC') or die;

/**
 * Remoteimage Manager model
 *
 * @since 1.0
 */
class RemoteimageModelManager extends ItemModel
{
	/**
	 * Component prefix.
	 *
	 * @var  string
	 */
	protected $prefix = 'remoteimage';

	/**
	 * The URL option for the component.
	 *
	 * @var  string
	 */
	protected $option = 'com_remoteimage';

	/**
	 * The prefix to use with messages.
	 *
	 * @var  string
	 */
	protected $textPrefix = 'COM_REMOTEIMAGE';

	/**
	 * The model (base) name
	 *
	 * @var  string
	 */
	protected $name = 'manager';

	/**
	 * Item name.
	 *
	 * @var  string
	 */
	protected $viewItem = 'manager';

	/**
	 * List name.
	 *
	 * @var  string
	 */
	protected $viewList = 'managers';

	/**
	 * Method to get a single record.
	 *
	 * @param   integer  $pk  The id of the primary key.
	 *
	 * @return  mixed    Object on success, false on failure.
	 */
	public function getItem($pk = null)
	{
		return parent::getItem($pk);
	}
}
