<?php
/**
 * @package        Asikart.Plugin
 * @subpackage     editors-xtd.plg_remoteimage
 * @copyright      Copyright (C) 2012 Asikart.com, Inc. All rights reserved.
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * Remoteimage Editors-xtd Plugin
 *
 * @package        Joomla.Plugin
 * @subpackage     Editors-xtd.remoteimage
 * @since          1.5
 */
class PlgButtonRemoteimage extends JPlugin
{
	/**
	 * Property self.
	 *
	 * @var PlgButtonRemoteimage
	 */
	public static $self;

	/**
	 * Constructor
	 *
	 * @param  object &$subject The object to observe
	 * @param  array  $config   An array that holds the plugin configuration
	 */
	public function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);

		$this->loadLanguage('com_remoteimage', JPATH_ADMINISTRATOR . '/components/com_remoteimage');
		$this->app = JFactory::getApplication();

		self::$self = $this;
	}

	/**
	 * Display the button
	 *
	 * @param string $name
	 * @param string $asset
	 * @param string $author
	 *
	 * @return array A two element array of (imageName, textToInsert)
	 */
	public function onDisplay($name, $asset, $author)
	{
		$app = JFactory::getApplication();
		$user = JFactory::getUser();

		if ($app->isSite() && !$user->authorise('frontend.access', 'com_remoteimage'))
		{
			return array();
		}

		// Add Script
		$doc = JFactory::getDocument();
		$doc->addScript(JURI::root(true) . '/administrator/components/com_remoteimage/asset/js/remoteimage-admin.js');

		// Add Button
		$user      = JFactory::getUser();
		$extension = $app->input->get('option');

		if ($asset == '')
		{
			$asset = $extension;
		}

		if ($user->authorise('core.edit', $asset)
			|| $user->authorise('core.create', $asset)
			|| (count($user->getAuthorisedCategories($asset, 'core.create')) > 0)
			|| ($user->authorise('core.edit.own', $asset) && $author == $user->id)
			|| (count($user->getAuthorisedCategories($extension, 'core.edit')) > 0)
			|| (count($user->getAuthorisedCategories($extension, 'core.edit.own')) > 0 && $author == $user->id))
		{
			$link = 'index.php?option=com_remoteimage&view=manager&tmpl=component&height=420&insert_id=' . $name;
			JHtml::_('behavior.modal');
			$button          = new JObject;
			$button->class   = 'btn';
			$button->modal   = true;
			$button->link    = $link;
			$button->text    = JText::_('COM_REMOTEIMAGE_IMAGE_BUTTON');
			$button->name    = 'picture';
			$button->options = "{handler: 'iframe', size: {x: 950, y: 550}}";

			return $button;
		}
		else
		{
			return false;
		}
	}

	/**
	 * getInstance
	 *
	 * @return  PlgButtonRemoteimage
	 */
	public static function getInstance()
	{
		return self::$self;
	}
}
