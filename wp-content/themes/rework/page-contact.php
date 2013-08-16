<?php
/*
Template Name: Contact
*/
?><?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php get_header(); ?>
<?php get_template_part("common","tagline"); ?>

<?php while ($t->content->looping() ) : ?>
<?php $gmap =& $t->content->meta()->gmap; ?>
<?php $contact =& $t->content->meta()->contact; ?>
<?php if ($gmap->show == "yes"): ?>
<!-- Google Map -->
<div id="google-map" class="gmap" data-latitude="<?php echo $gmap->latitude; ?>" data-longitude="<?php echo $gmap->longitude; ?>" data-title="<?php echo esc_attr($gmap->title); ?>" data-zoom="<?php echo $gmap->zoom; ?>" >
	<div class="description"><?php echo $gmap->description; ?></div>
</div>
<!-- /Google Map -->
<?php endif; ?>

<div class="contact-intro">
	<?php $t->content->content(); ?>
</div>

<!-- Contact Info -->
<div class="contact-info one-fourth">
	<h4><?php $t->content->title(); ?></h4>
	<?php if ($contact->title): ?>
	<p class="address"><?php echo $contact->address ?></p>
	<?php endif; ?>
	<?php if ($contact->phone): ?>
	<p class="phone"><?php echo $contact->phone ?></p>
	<?php endif; ?>
	<?php if ($contact->email): ?>
	<p class="email"><?php echo $contact->email ?></p>
	<?php endif; ?>
</div>
<!-- /Contact Info -->

<!-- Contact Form -->
<div class="contact-form three-fourth last">

	<h4><?php echo $contact->title ?></h4>
	
	<form method="post" id="contact-form" class="peThemeContactForm">
		<!--alert success-->
		<div id="contactFormSent" class="success" style="display: none">
			<?php echo $contact->msgOK; ?>
		</div>
											
		<!--alert error-->
		<div id="contactFormError" class="error" style="display: none">
			<?php echo $contact->msgKO; ?>
		</div>

		<input type="text" value="Name" id="name" name="author" default-value="Name" class="required" />
		<input type="text" value="Email" id="email" name="email" default-value="Email" class="required" data-validation="email" />
		<textarea cols="88" rows="6" id="message" name="message" default-value="Message" class="required">Message</textarea>
		<input type="submit" value="Submit Form " class="red" />
	</form>
</div>
<!-- /Contact Form -->
<?php endwhile; ?>

<?php get_footer(); ?>
