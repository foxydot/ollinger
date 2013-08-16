<?php $t =& peTheme(); ?>
<?php $videoID = $t->content->meta()->video->id; ?>
<?php if ($video = $t->video->getInfo($videoID)): ?>
<div class="video">
	<?php switch($video->type): case "youtube": ?>
	<iframe width="680" height="383" src="http://www.youtube.com/embed/<?php echo $video->id; ?>?autohide=1&modestbranding=1&showinfo=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
	<?php break; case "vimeo": ?>
	<iframe src="http://player.vimeo.com/video/<?php echo $video->id; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="680" height="383" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
	<?php endswitch; ?>
</div>
<?php endif; ?>