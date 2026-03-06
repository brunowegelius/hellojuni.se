<?php
/**
 * The template to display Admin notices
 *
 * @package YUCCA
 * @since YUCCA 1.0.1
 */

$yucca_theme_slug = get_option( 'template' );
$yucca_theme_obj  = wp_get_theme( $yucca_theme_slug );
?>
<div class="yucca_admin_notice yucca_welcome_notice notice notice-info is-dismissible" data-notice="admin">
	<?php
	// Theme image
	$yucca_theme_img = yucca_get_file_url( 'screenshot.jpg' );
	if ( '' != $yucca_theme_img ) {
		?>
		<div class="yucca_notice_image"><img src="<?php echo esc_url( $yucca_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'yucca' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="yucca_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'yucca' ),
				$yucca_theme_obj->get( 'Name' ) . ( YUCCA_THEME_FREE ? ' ' . __( 'Free', 'yucca' ) : '' ),
				$yucca_theme_obj->get( 'Version' )
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="yucca_notice_text">
		<p class="yucca_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $yucca_theme_obj->description ) );
			?>
		</p>
		<p class="yucca_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'yucca' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="yucca_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=yucca_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'yucca' );
			?>
		</a>
	</div>
</div>
