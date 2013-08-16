<?php $logos =& peTheme()->content->meta()->logos; ?>
<?php if ($logos->show === "yes"): ?>
<!-- Logo List -->
<div class="logo-list">
	<ul>
		<?php for ($i=1; $i<=5;$i++): ?>
		<?php $logo = $logos->{"logo$i"}; ?>
		<?php if (empty($logo)) continue ?>
		<?php $link = $logos->{"link$i"}; ?>
		<li>
			<?php if ($link): ?>
			<a href="<?php echo $link; ?>">
			<?php endif; ?>
				<div class="bw-wrapper">
					<img src="<?php echo $logos->{"logo$i"} ?>" alt="" />
				</div>
			<?php if ($link): ?>
			</a>
			<?php endif; ?>
		</li>
		<?php endfor; ?>
	</ul>
</div>
<!-- /Logo List -->
<?php endif; ?>
