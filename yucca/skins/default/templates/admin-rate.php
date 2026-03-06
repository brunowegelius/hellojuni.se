<?php
/**
 * The template to display Admin notices
 *
 * @package YUCCA
 * @since YUCCA 1.0.1
 */

$yucca_theme_slug = get_template();
$yucca_theme_obj  = wp_get_theme( $yucca_theme_slug );

?>
<div class="yucca_admin_notice yucca_rate_notice notice notice-info is-dismissible" data-notice="rate">
	<?php
	// Theme image
	$yucca_theme_img = yucca_get_file_url( 'screenshot.jpg' );
	if ( '' != $yucca_theme_img ) {
		?>
		<div class="yucca_notice_image"><img src="<?php echo esc_url( $yucca_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'yucca' ); ?>"></div>
		<?php
	}

	// Title
	$yucca_theme_name = '"' . $yucca_theme_obj->get( 'Name' ) . ( YUCCA_THEME_FREE ? ' ' . __( 'Free', 'yucca' ) : '' ) . '"';
	?>
	<h3 class="yucca_notice_title"><a href="<?php echo esc_url( yucca_storage_get( 'theme_rate_url' ) ); ?>"<?php if ( function_exists( 'yucca_external_links_target' ) ) echo yucca_external_links_target( true ); ?>>
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name to the 'Welcome' message
				__( 'Help Us Grow - Rate %s Today!', 'yucca' ),
				$yucca_theme_name
			)
		);
		?>
	</a></h3>
	<?php

	// Description
	?>
	<div class="yucca_notice_text">
		<p><?php
			// Translators: Add theme name to the 'Welcome' message
			echo wp_kses_data( sprintf( __( "Thank you for choosing the %s theme for your website! We're excited to see how you've customized your site, and we hope you've enjoyed working with our theme.", 'yucca' ), $yucca_theme_name ) );
		?></p>
		<p><?php
			// Translators: Add theme name to the 'Welcome' message
			echo wp_kses_data( sprintf( __( "Your feedback really matters to us! If you've had a positive experience, we'd love for you to take a moment to rate %s and share your thoughts on the customer service you received.", 'yucca' ), $yucca_theme_name ) );
		?></p>
	</div>
	<?php

	// Buttons
	?>
	<div class="yucca_notice_buttons">
		<?php
		// Link to the theme download page
		?>
		<a href="<?php echo esc_url( yucca_storage_get( 'theme_rate_url' ) ); ?>" class="button button-primary"<?php if ( function_exists( 'yucca_external_links_target' ) ) echo yucca_external_links_target( true ); ?>><i class="dashicons dashicons-star-filled"></i> 
			<?php
			// Translators: Add the theme name to the button caption
			echo esc_html( sprintf( __( 'Rate %s Now', 'yucca' ), $yucca_theme_name ) );
			?>
		</a>
		<?php
		// Link to the theme support
		?>
		<a href="<?php echo esc_url( yucca_storage_get( 'theme_support_url' ) ); ?>" class="button"<?php if ( function_exists( 'yucca_external_links_target' ) ) echo yucca_external_links_target( true ); ?>><i class="dashicons dashicons-sos"></i> 
			<?php
			esc_html_e( 'Support', 'yucca' );
			?>
		</a>
		<?php
		// Link to the theme documentation
		?>
		<a href="<?php echo esc_url( yucca_storage_get( 'theme_doc_url' ) ); ?>" class="button"<?php if ( function_exists( 'yucca_external_links_target' ) ) echo yucca_external_links_target( true ); ?>><i class="dashicons dashicons-book"></i> 
			<?php
			esc_html_e( 'Documentation', 'yucca' );
			?>
		</a>
	</div>
</div>
