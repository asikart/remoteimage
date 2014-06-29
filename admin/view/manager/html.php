<?php
/**
 * Part of Component Remoteimage files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Windwalker\DI\Container;
use Windwalker\Model\Model;
use Windwalker\View\Engine\PhpEngine;
use Windwalker\View\Html\HtmlView;

// No direct access
defined('_JEXEC') or die;

/**
 * Remoteimage Managers view
 *
 * @since 1.0
 */
class RemoteimageViewManagerHtml extends HtmlView
{
	/**
	 * The component prefix.
	 *
	 * @var  string
	 */
	protected $prefix = 'remoteimage';

	/**
	 * The component option name.
	 *
	 * @var string
	 */
	protected $option = 'com_remoteimage';

	/**
	 * The text prefix for translate.
	 *
	 * @var  string
	 */
	protected $textPrefix = 'COM_REMOTEIMAGE';

	/**
	 * The item name.
	 *
	 * @var  string
	 */
	protected $name = 'manager';

	/**
	 * The item name.
	 *
	 * @var  string
	 */
	protected $viewItem = 'manager';

	/**
	 * The list name.
	 *
	 * @var  string
	 */
	protected $viewList = 'managers';

	/**
	 * Method to instantiate the view.
	 *
	 * @param Model            $model     The model object.
	 * @param Container        $container DI Container.
	 * @param array            $config    View config.
	 * @param SplPriorityQueue $paths     Paths queue.
	 */
	public function __construct(Model $model = null, Container $container = null, $config = array(), \SplPriorityQueue $paths = null)
	{
		$this->engine = new PhpEngine;

		parent::__construct($model, $container, $config, $paths);
	}

	/**
	 * Prepare data hook.
	 *
	 * @return  void
	 */
	protected function prepareData()
	{
		$input = $this->container->get('input');
		$data = $this->getData();

		$data->params = $params = \Windwalker\System\ExtensionHelper::getParams('com_remoteimage');

		$lang = $this->container->get('language');
		$data->langCode = $lang->getTag();
		$data->langCode = str_replace('-', '_', $data->langCode);

		$this->prepareScript();

		if ('component' == $input->get('tmpl'))
		{
			$params->set('isModal', true);
			$data->modal = true;
		}
		else
		{
			$params->set('isModal', false);
			$data->modal = false;
		}

		$params->set('tabs', $data->modal);
		$params->set('height', $data->modal ? $input->get('height', 380) : 520);
		$params->set('fieldId', $input->get('fieldid'));
		$params->set('insertId', $input->get('insert_id'));

		$data->uploadMax = ini_get('upload_max_filesize');
		$data->uploadNum = ini_get('max_file_uploads');

		$this->setTitle(JText::_('COM_REMOTEIMAGE_TITLE_MANAGER'));
		JToolbarHelper::preferences('com_remoteimage');
	}

	/**
	 * Display elFinder script.
	 *
	 * @return void
	 */
	private function prepareScript()
	{
		$lang_code = $this->data->langCode;

		// Include elFinder and JS
		// ================================================================================

		$asset = $this->container->get('helper.asset');

		// JQuery
		$asset->mootools();
		$asset->jquery();
		$asset->bootstrap();

		// ElFinder includes
		$asset->addCss('js/jquery-ui/css/smoothness/jquery-ui-1.8.24.custom.css');
		$asset->addCss('js/elfinder/css/elfinder.min.css');
		$asset->addCss('js/elfinder/css/theme.css');
		$asset->addCss('remoteimage.css');

		$asset->addJs('js/jquery-ui/js/jquery-ui.min.js');
		$asset->addJs('js/elfinder/js/elfinder.full.js');

		if (is_file(REMOTEIMAGE_ADMIN . '/asset/js/elfinder/js/i18n/elfinder.' . $lang_code . '.js'))
		{
			$asset->addJs('js/elfinder/js/i18n/elfinder.' . $lang_code . '.js');
		}
	}
}
