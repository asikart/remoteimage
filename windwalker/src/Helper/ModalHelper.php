<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Windwalker\Helper;

use Joomla\CMS\Form\Form;
use Windwalker\DI\Container;

defined('_JEXEC') or die;

/**
 * A UI helper to generate modal etc.
 *
 * @since 2.0
 */
class ModalHelper
{
	/**
	 * Set a HTML element as modal container.
	 *
	 * @param   string $selector Modal ID to select element.
	 * @param   array  $option   Modal options.
	 *
	 * @return  void
	 *
	 * @deprecated  3.0  This method was used by the old renderModal() implementation.
	 *                   Since the new implementation it is unneeded and the broken JS it was injecting could create issues
	 *                   As a case, please see: https://github.com/joomla/joomla-cms/pull/6918
	 */
	public static function modal($selector, $option = array())
	{
		return;
	}

	/**
	 * The link to open modal.
	 *
	 * @param   string  $title    Modal title.
	 * @param   string  $selector Modal select ID.
	 * @param   array   $option   Modal params.
	 *
	 * @return  string  Link body text.
	 */
	public static function modalLink($title, $selector, $option = array())
	{
		$tag     = ArrayHelper::getValue($option, 'tag', 'a');
		$id      = isset($option['id']) ? " id=\"{$option['id']}\"" : " id=\"{$selector}_link\"";
		$class   = isset($option['class']) ? " class=\"{$option['class']} cursor-pointer\"" : ' class="cursor-pointer"';
		$onclick = isset($option['onclick']) ? " onclick=\"{$option['onclick']}\"" : '';
		$icon    = ArrayHelper::getValue($option, 'icon', '');

		$button = <<<HTML
<{$tag} data-toggle="modal" data-target="#$selector"{$id}{$class}{$onclick}>
	<i class="{$icon}" title="$title"></i>
	$title
</{$tag}>
HTML;

		return $button;
	}

	/**
	 * Put content and render it as modal box HTML.
	 *
	 * @param   string $selector The ID selector for the modal.
	 * @param   string $content  HTML content to put in modal.
	 * @param   array  $option   Optional markup for the modal, footer or title.
	 *
	 * @return  string  HTML markup for a modal
	 */
	public static function renderModal($selector = 'modal', $content = '', $option = array())
	{
		$header = '';
		$footer = '';

		// Header
		if (!empty($option['title']))
		{
			$header = <<<HEADER
<div class="modal-header">
    <button type="button" role="presentation" class="close" data-dismiss="modal">x</button>
    <h3>{$option['title']}</h3>
</div>
HEADER;
		}

		// Footer
		if (!empty($option['footer']))
		{
			$footer = <<<FOOTER
<div class="modal-footer">
    {$option['footer']}
</div>
FOOTER;
		}

		// Box
		$html = <<<HTML
<div class="modal hide fade {$selector}" id="{$selector}">
{$header}

<div id="{$selector}-container" class="modal-body">
    <div class="container-fluid">
        <div class="span12">
        {$content}
		</div>
	</div>
</div>

{$footer}
</div>
HTML;

		return $html;
	}

	/**
	 * Get Quickadd Form.
	 *
	 * @param integer $id        Form id.
	 * @param string  $path      The form path.
	 * @param string  $extension The extension(handler).
	 *
	 * @return  bool|string
	 */
	static public function getQuickaddForm($id, $path, $extension = null)
	{
		$content = '<div class="alert alert-info">' . \Joomla\CMS\Language\Text::_('LIB_WINDWALKER_QUICKADD_HOTKEY_DESC') . '</div>';

		try
		{
			$form = new Form($id . '.quickaddform', array('control' => $id));

			$form->loadFile(JPATH_ROOT . '/' . $path);
		}
		catch (\Exception $e)
		{
			$app = Container::getInstance()->get('app');
			$app->enqueueMessage($e->getMessage());

			return false;
		}

		// Set Category Extension
		if ($extension)
		{
			$form->setValue('extension', null, $extension);
		}

		$fieldset = $form->getFieldset('quickadd');

		foreach ($fieldset as $field)
		{
			$content .= <<<HTML
<div class="control-group" id="{$field->id}-wrap">
	<div class="control-label">
		{$field->label}
	</div>
	<div class="controls">
		{$field->input}
	</div>
</div>
HTML;
		}

		return $content;
	}
}
