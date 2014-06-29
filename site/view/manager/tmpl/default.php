<?php
/**
 * Part of Component Remoteimage files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Remoteimage\Router\Route;
use Windwalker\View\Helper\ViewHtmlHelper;

// No direct access
defined('_JEXEC') or die;

/**
 * Prepare data for this template.
 *
 * @var $container Windwalker\DI\Container
 * @var $data      Windwalker\Data\Data
 * @var $item      Windwalker\Data\Data
 * @var $params    Joomla\Registry\Registry
 */
$container = $this->getContainer();
$params = $data->item->params;
$item = $data->item;
?>

<form action="<?php echo JUri::getInstance(); ?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">

	<div id="Remoteimage" class="windwalker item container-fluid manager<?php echo $params->get('pageclass_sfx'); ?>">
		<div id="remoteimage-wrap-inner">

			<div class="manager-item item<?php echo $item->state == 0 ? ' well well-small' : ''; ?>">
				<div class="manager-item-inner">

					<!-- Heading -->
					<!-- ============================================================================= -->
					<div class="heading">
						<h2><?php echo $params->get('link_titles', 1) ? JHtml::_('link', $item->link, $item->title) : $item->title ?></h2>
					</div>
					<!-- ============================================================================= -->
					<!-- Heading -->

					<!-- afterDisplayTitle -->
					<!-- ============================================================================= -->
					<?php echo $data->item->event->afterDisplayTitle; ?>
					<!-- ============================================================================= -->
					<!-- afterDisplayTitle -->

					<!-- beforeDisplayContent -->
					<!-- ============================================================================= -->
					<?php echo $data->item->event->beforeDisplayContent; ?>
					<!-- ============================================================================= -->
					<!-- beforeDisplayContent -->

					<!-- Info -->
					<!-- ============================================================================= -->
					<div class="info">
						<div class="info-inner">
							<?php echo ViewHtmlHelper::showInfo($item, 'category_title', 'jcategory', 'folder', Route::_('com_remoteimage.managers', array('id' => $item->catid))); ?>
							<?php echo ViewHtmlHelper::showInfo($item, 'created', 'com_remoteimage_created', 'calendar'); ?>
							<?php echo ViewHtmlHelper::showInfo($item, 'modified', 'com_remoteimage_modified', 'calendar'); ?>
							<?php echo ViewHtmlHelper::showInfo($item, 'name', 'com_remoteimage_created_by', 'user'); ?>
						</div>
					</div>

					<hr class="info-separator" />
					<!-- ============================================================================= -->
					<!-- Info -->

					<!-- Content -->
					<!-- ============================================================================= -->
					<div class="content">
						<div class="content-inner row-fluid">

							<div class="span12">
								<?php if (!empty($item->images)): ?>
									<div class="content-img">
										<?php echo JHtml::_('image', $item->images, $item->title); ?>
									</div>
								<?php endif; ?>

								<div class="text">
									<?php echo $item->text; ?>
								</div>
							</div>

						</div>
					</div>
					<!-- ============================================================================= -->
					<!-- Content End -->

					<!-- afterDisplayContent -->
					<!-- ============================================================================= -->
					<?php echo $data->item->event->afterDisplayContent; ?>
					<!-- ============================================================================= -->
					<!-- afterDisplayContent -->

				</div>
			</div>

		</div>
	</div>

	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="return" value="<?php echo base64_encode(JUri::getInstance()->toString()); ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>        
