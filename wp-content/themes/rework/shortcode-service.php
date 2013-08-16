<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $t->content->meta(); ?>
<div class="service">
	<div class="service-icon">
		<img src="<?php echo PE_THEME_URL; ?>/images/content/services_icon_<?php echo $meta->info->icon; ?>.png" alt="" />
	</div>
	<div class="service-description">
		<h4><?php $content->title(); ?></h4>
		<?php $content->content(); ?>
		<ul>
			<?php foreach ($meta->info->features as $feature): ?>
			<li><?php echo $feature; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
