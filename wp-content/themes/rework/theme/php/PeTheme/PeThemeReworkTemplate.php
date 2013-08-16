<?php

class PeThemeReworkTemplate extends PeThemeTemplate {

	public function paginate_links($loop) {
		if (!$loop) return "";
?>
			<ul class="pagination">
				<li class="<?php echo $loop->main->prev->class ?> prev">
					<a href="<?php echo $loop->main->prev->link ?>"><?php e__pe("Prev"); ?></a>
				</li>
				<?php while ($page =& $loop->next()): $current = str_replace("active","current",$page->class) ?>
				<li class="<?php echo $current; ?>">
					<?php if ($current): ?>
					<?php echo $page->num; ?>
					<?php else: ?>
					<a href="<?php echo $page->link; ?>"><?php echo $page->num; ?></a>
					<?php endif; ?>
				</li>
				<?php endwhile; ?>
				<li class="<?php echo $loop->main->next->class ?> next">
					<a href="<?php echo $loop->main->next->link ?>"><?php e__pe("Next"); ?></a>
				</li>
			</ul>
<?php
	}


}

?>