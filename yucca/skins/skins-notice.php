<?php
/**
 * The template to display Admin notices
 *
 * @package YUCCA
 * @since YUCCA 1.0.64
 */

$yucca_skins_url  = get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_skins' );
$yucca_skins_args = get_query_var( 'yucca_skins_notice_args' );
?>
<div class="yucca_admin_notice yucca_skins_notice notice notice-info is-dismissible" data-notice="skins">
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
		<?php esc_html_e( 'New skins are available', 'yucca' ); ?>
	</h3>
	<?php

	// Description
	$yucca_total      = $yucca_skins_args['update'];	// Store value to the separate variable to avoid warnings from ThemeCheck plugin!
	$yucca_skins_msg  = $yucca_total > 0
							// Translators: Add new skins number
							? '<strong>' . sprintf( _n( '%d new version', '%d new versions', $yucca_total, 'yucca' ), $yucca_total ) . '</strong>'
							: '';
	$yucca_total      = $yucca_skins_args['free'];
	$yucca_skins_msg .= $yucca_total > 0
							? ( ! empty( $yucca_skins_msg ) ? ' ' . esc_html__( 'and', 'yucca' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d free skin', '%d free skins', $yucca_total, 'yucca' ), $yucca_total ) . '</strong>'
							: '';
	$yucca_total      = $yucca_skins_args['pay'];
	$yucca_skins_msg .= $yucca_skins_args['pay'] > 0
							? ( ! empty( $yucca_skins_msg ) ? ' ' . esc_html__( 'and', 'yucca' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d paid skin', '%d paid skins', $yucca_total, 'yucca' ), $yucca_total ) . '</strong>'
							: '';
	?>
	<div class="yucca_notice_text">
		<p>
			<?php
			// Translators: Add new skins info
			echo wp_kses_data( sprintf( __( "We are pleased to announce that %s are available for your theme", 'yucca' ), $yucca_skins_msg ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="yucca_notice_buttons">
		<?php
		// Link to the theme dashboard page
		?>
		<a href="<?php echo esc_url( $yucca_skins_url ); ?>" class="button button-primary"><i class="dashicons dashicons-update"></i> 
			<?php
			esc_html_e( 'Go to Skins manager', 'yucca' );
			?>
		</a>
		<?php
		// Dismiss notice for 7 days
		?>
		<a href="#" role="button" class="button button-secondary yucca_notice_button_dismiss" data-notice="skins"><i class="dashicons dashicons-no-alt"></i> 
			<?php
			esc_html_e( 'Dismiss', 'yucca' );
			?>
		</a>
		<?php
		// Hide notice forever
		?>
		<a href="#" role="button" class="button button-secondary yucca_notice_button_hide" data-notice="skins"><i class="dashicons dashicons-no-alt"></i> 
			<?php
			esc_html_e( 'Never show again', 'yucca' );
			?>
		</a>
	</div>
</div>
