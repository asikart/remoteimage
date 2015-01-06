<?php
/**
 * @package        Asikart.Plugin
 * @subpackage     system.plg_remoteimage
 * @copyright      Copyright (C) 2012 Asikart.com, Inc. All rights reserved.
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * Remoteimage System Plugin
 *
 * @package        Joomla.Plugin
 * @subpackage     System.remoteimage
 * @since          1.5
 */
class PlgSystemRemoteimage extends JPlugin
{
	/**
	 * Property _self.
	 *
	 * @var PlgSystemRemoteimage
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
		$this->loadLanguage();
		$this->loadLanguage('com_remoteimage', JPATH_ADMINISTRATOR . '/components/com_remoteimage');
		$this->app = JFactory::getApplication();

		self::$self = $this;
	}

	/**
	 * getInstance
	 *
	 * @return  PlgSystemRemoteimage
	 */
	public static function getInstance()
	{
		return self::$self;
	}

	// System Events
	// ======================================================================================

	/**
	 * onAfterRoute
	 *
	 * @throws  Exception
	 * @return  void
	 */
	public function onAfterRoute()
	{
		$params  = JComponentHelper::getParams('com_remoteimage');

		$user = JFactory::getUser();

		$auth = ($user->authorise('core.manage', 'com_remoteimage'));

		if ($params->get('Integrate_Override_InsertImageArticle', 1)
			|| $params->get('Integrate_Override_MediaFormField', 1)
			|| $params->get('Integrate_Override_MediaManager', 1))
		{
			$this->redirectNativeMedia();
		}
	}

	/**
	 * redirectNativeMedia
	 *
	 * @return  void
	 *
	 * @throws Exception
	 */
	protected function redirectNativeMedia()
	{
		$app = JFactory::getApplication();
		$user = JFactory::getUser();

		if ($app->isSite() && !$user->authorise('frontend.access', 'com_remoteimage'))
		{
			return;
		}

		$app   = JFactory::getApplication();
		$input = $app->input;

		$uri     = JUri::getInstance();
		$option  = $input->get('option');
		$view    = $input->get('view');
		$tmpl    = $input->get('tmpl');
		$fieldid = $input->get('fieldid');
		$params  = JComponentHelper::getParams('com_remoteimage');

		$doc = JFactory::getDocument();
		$doc->addScript(JURI::root(true) . '/administrator/components/com_remoteimage/asset/js/remoteimage-admin.js');

		// Replace Insert to Article
		if ($option == 'com_media' && $view == 'images' && !$fieldid && $tmpl == 'component' && $params->get('Integrate_Override_InsertImageArticle', 1))
		{
			$uri->setVar('option', 'com_remoteimage');
			$uri->delVar('view');
			$uri->setVar('insert_id', $input->get('e_name'));

			$app->redirect((string) $uri);
		}

		// Replace FormField
		if ($option == 'com_media' && $view == 'images' && $fieldid && $tmpl == 'component' && $params->get('Integrate_Override_MediaFormField', 1))
		{
			$uri->setVar('option', 'com_remoteimage');
			$uri->delVar('view');

			$app->redirect((string) $uri);
		}

		// Replace Media Manager
		if ($option == 'com_media' && ($view == 'image' || !$view) && $params->get('Integrate_Override_MediaManager', 1))
		{
			$uri->setVar('option', 'com_remoteimage');
			$uri->delVar('view');

			$app->redirect((string) $uri);
		}
	}
}
