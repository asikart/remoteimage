<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_remoteimage
 *
 * @copyright   Copyright (C) 2012 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;


// Init some API objects
// ================================================================================
$data = $this->data;
$date = JFactory::getDate('now', JFactory::getConfig()->get('offset'));
$doc = JFactory::getDocument();
$uri = \JUri::getInstance();
$user = JFactory::getUser();
$app = JFactory::getApplication();


// PARAMS
/**
 * @var $lang   string
 * @var $params Joomla\Registry\Registry
 */
$lang      = $data->langCode;
$lang      = substr($data->langCode, 0, 2);
$params    = $data->params;
$safemode  = $params->get('Safemode', true);
$onlyimage = $params->get('Onlyimage', false);
$tabs      = $params->get('tabs', false);
$height    = $params->get('height', 350);

// System Info
$sysinfo = JText::_('COM_REMOTEIMAGE_UPLOAD_MAX') . ' ' . $data->uploadMax;
$sysinfo .= ' | ' . JText::_('COM_REMOTEIMAGE_UPLOAD_NUM') . ' ' . $data->uploadNum;


// Is FormField
$fieldid = $params->get('fieldId');
?>
<script type="text/javascript">
	var elFinder;
	var elSelected = [];
	var el;
	var RMinModal;
	var root_uri = '<?php echo JURI::root(); ?>';
	var insert_template_image = '<?php echo str_replace(",", "\,", $params->get('Integrate_InsertTemplateImage', '<p>{%CONTENT%}</p>')); ?>';
	var insert_template_link = '<?php echo str_replace(",", "\,", $params->get('Integrate_InsertTemplateLink', '{%CONTENT%}')); ?>';

	// Insert Image to Article
	var insertImageToParent = function()
	{
		var imgs = elSelected;
		var elFinder = window.elFinder;
		var urls = $('insert-from-url').get('value');

		var tags = '';

		var option = {
			fixAll: $('rm-setwidth').checked,
			dW: $('rm-width').get('value').toInt(),
			insert_template_image: insert_template_image,
			insert_template_link: insert_template_link,
			root_uri: root_uri
		};

		window.parent.Remoteimage.insertImages('<?php echo $params->get('insertId'); ?>', imgs, urls, elFinder, option);
	};

	var insertFormField = function()
	{
		var imgs = elSelected;
		var elFinder = window.elFinder;
		var urls = $('insert-from-url').get('value');

		// Handle From Urls
		urls = urls.toString().trim();

		if (urls)
		{
			url = urls.split("\n")[0];

		} else
		{
			// Insert From Selected
			if (elSelected.length < 1)
			{
				return;
			}

			var img = imgs[0];
			url = elFinder.url(img.hash);

		}

		url = url.replace(root_uri, '');
		console.log(url);
		window.parent.jInsertFieldValue(url, '<?php echo $fieldid; ?>');

		setTimeout(function()
		{
			if (window.parent)
			{
				window.parent.SqueezeBox.close();
			}
		}, 50);
	};

	// Init elFinder
	jQuery(document).ready(function($)
	{

		var elConfig = {
			url: 'index.php?option=com_remoteimage&task=manager.connect',
			// url: 'components/com_remoteimage/src/Remoteimage/Controller/test.json',
			width: '100%',
			height: '<?php echo $height; ?>',
			lang: '<?php echo $lang; ?>',
			requestType: 'post',
			handlers: {
				select: function(event, elfinderInstance)
				{
					var selected = event.data.selected;

					if (selected.length)
					{
						elSelected = [];
						jQuery.each(selected, function(i, e)
						{
							elSelected[i] = elfinderInstance.file(e);
						});
					}

				}
			},
			uiOptions: {
				// toolbar configuration
				toolbar: [
					['back', 'forward'],
					['reload'],
					['home', 'up'],
					['mkdir', 'mkfile', 'upload'],
					['open', 'download', 'getfile'],
					//['info'],
					['quicklook'],
					['copy', 'cut', 'paste'],
					['rm'],
					['duplicate', 'rename', 'edit', 'resize'],
					['extract', 'archive'],
					['search'],
					['view'],
					['help']
				]
			}
			<?php if( $data->modal ): ?>,
			getFileCallback: function(file)
			{
				<?php echo $fieldid ? 'insertFormField();' : 'insertImageToParent();'; ?>
			}

			<?php endif; ?>

		};

		<?php if( $onlyimage ): ?>
		elConfig.onlyMimes = ['image'];
		<?php endif; ?>

		elFinder = $('#elfinder').elfinder(elConfig).elfinder('instance');

		elFinder.ui.statusbar.append('<?php echo $sysinfo; ?>');
	});
</script>

<style type="text/css">
	<?php if( $data->modal ): ?>
	body {
		margin  : 0 !important;
		padding : 0 !important;
	}

	<?php endif; ?>
</style>

<div id="remoteimage-manager" class="remoteimage">

	<?php echo $tabs ? JHtmlBootstrap::startTabSet('RMTabs', array('active' => 'panel-elfinder')) : ''; ?>

	<?php echo $tabs ? JHtmlBootstrap::addTab('RMTabs', 'panel-elfinder', JText::_('COM_REMOTEIMAGE_MANAGER')) : ''; ?>
	<!-- elFinder Body -->
	<div class="row-fluid">
		<div id="elfinder" class="span12 rm-finder">

		</div>
	</div>
	<?php echo $tabs ? JHtmlBootstrap::endTab() : null; ?>

	<?php if ($data->modal): ?>
		<!--Insert From URL-->
		<?php echo $tabs ? JHtmlBootstrap::addTab('RMTabs', 'panel-url', JText::_('COM_REMOTEIMAGE_INSERT_FROM_URL')) : ''; ?>
		<?php echo JText::_('COM_REMOTEIMAGE_INSERT_FROM_URL_DESC'); ?>
		<br /><br />
		<textarea name="insert-from-url" id="insert-from-url" cols="30" class="span9" rows="10"></textarea>
		<?php echo $tabs ? JHtmlBootstrap::endTab() : null; ?>
	<?php endif; ?>
	<?php echo $tabs ? JHtmlBootstrap::endTabSet() : null; ?>


	<?php if ($data->modal): ?>
		<div class="row-fluid">
			<div id="rm-insert-panel" class="span12 form-actions">
				<div class="form-inline pull-left">
					<label for="rm-width" id="rm-width-lbl" class=""><?php echo JText::_('COM_REMOTEIMAGE_MAX_WIDTH'); ?></label>
					<input type="text" id="rm-width" class="input input-mini" value="<?php echo $data->params->get('Image_DefaultWidth_Midium', 640); ?>" />
					&nbsp;&nbsp;
					<!--<span class="rm-width-height-x">X</span>
					<input type="text" id="rm-height" class="input input-mini" value="<?php echo $data->params->get('Image_DefaultHeight_Midium', 640); ?>" />
					-->
					<label for="rm-setwidth">
						<input type="checkbox" id="rm-setwidth" name="rm-setwidth" value="1" />
						<?php echo JText::_('COM_REMOTEIMAGE_FIX_ALL_IMAGE_WIDTH'); ?>
					</label>
				</div>

				<div class="btns pull-right fltrt">

					<button id="rm-insert-button" class="btn btn-primary" onclick="<?php echo $fieldid ? 'insertFormField();' : 'insertImageToParent();'; ?>">
						<?php echo JText::_('COM_REMOTEIMAGE_INSERT_IMAGES'); ?>
					</button>

					<button id="rm-cancel-button" class="btn" onclick="window.parent.SqueezeBox.close();">
						<?php echo JText::_('JLIB_HTML_BEHAVIOR_CLOSE'); ?>
					</button>

				</div>
			</div>
		</div>
	<?php endif; ?>

</div>
