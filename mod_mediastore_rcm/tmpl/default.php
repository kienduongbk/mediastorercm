<?php
/**
 * @copyright	Copyright (c) 2013 Skyline Technology Ltd (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;
$img_width	= 960 / 3;

$app = JFactory::getApplication();
$params = JComponentHelper::getParams('com_mediastore');
?>

<div class="mediastore-rcm owl-carousel owl-loaded owl-drag" data-id="<?php echo $module->id; ?>">
	<?php foreach($items as $item):?>
		<?php $item->params = $params;?>
		<?php $link	= JRoute::_(MediaStoreHelperRoute::getProductRoute($item->slug, $item->category_id)); ?>
		<div class="item">
			<div class="thumbnail">
				<a href="<?php echo $link; ?>">
					<?php echo JHtml::_('mediastore.image', $item->thumbnail, $img_width, null, $item->title); ?>
					<span><?php echo $item->title; ?></span>
				</a>
			</div>
			<div class="product-price">
				<?php echo JHtml::_('mediastore.price', $item->price); ?>
			</div>
			<div class="cart-buttons">
				<form action="<?php echo $link; ?>" method="post" class="add-to-cart-form"<?php echo $item->params->get('enable_ajaxcart', 1) ? ' data-ajax="true"' : ''; ?>>

					<button class="btn btn-primary add-to-cart-button" type="submit">
						<i class="icon-cart fa fa-shopping-cart"></i> <?php echo JText::_('COM_MEDIASTORE_ADD_TO_CART'); ?>
					</button>

					<input type="hidden" name="option" value="com_mediastore" />
					<input type="hidden" name="task" value="cart.add" />
					<input type="hidden" name="id" value="<?php echo $item->id; ?>" />
				</form>
			</div>
		</div>
	<?php endforeach; ?>
</div>