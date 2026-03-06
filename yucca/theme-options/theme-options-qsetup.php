<?php
/**
 * Quick Setup Section in the Theme Panel
 *
 * @package YUCCA
 * @since YUCCA 1.0.48
 */


if ( ! function_exists( 'yucca_options_qsetup_add_scripts' ) ) {
	add_action("admin_enqueue_scripts", 'yucca_options_qsetup_add_scripts');
	/**
	 * Load required styles and scripts for admin mode for the 'Quick Setup' section in the Theme Panel.
	 * 
	 * @hooked 'admin_enqueue_scripts'
	 */
	function yucca_options_qsetup_add_scripts() {
		if ( ! YUCCA_THEME_FREE ) {
			$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : false;
			if ( is_object( $screen ) && ! empty( $screen->id ) && false !== strpos($screen->id, 'page_trx_addons_theme_panel') ) {
				wp_enqueue_style( 'yucca-fontello', yucca_get_file_url( 'css/font-icons/css/fontello.css' ), array(), null );
				wp_enqueue_script( 'jquery-ui-tabs', false, array( 'jquery', 'jquery-ui-core' ), null, true );
				wp_enqueue_script( 'jquery-ui-accordion', false, array( 'jquery', 'jquery-ui-core' ), null, true );
				wp_enqueue_script( 'yucca-options', yucca_get_file_url( 'theme-options/theme-options.js' ), array( 'jquery' ), null, true );
				wp_localize_script( 'yucca-options', 'yucca_dependencies', yucca_get_theme_dependencies() );
				wp_localize_script(	'yucca-options', 'yucca_options_vars', apply_filters(
					'yucca_filter_options_vars', array(
						'max_load_fonts'            => yucca_get_theme_setting( 'max_load_fonts' ),
						'save_only_changed_options' => yucca_get_theme_setting( 'save_only_changed_options' ),
					)
				) );
			}
		}
	}
}


if ( ! function_exists( 'yucca_options_qsetup_theme_panel_steps' ) ) {
	add_filter( 'trx_addons_filter_theme_panel_steps', 'yucca_options_qsetup_theme_panel_steps' );
	/**
	 * Add the step with the 'Quick Setup' section to the Theme Panel steps.
	 * 
	 * @hooked 'trx_addons_filter_theme_panel_steps'
	 * 
	 * @param array $steps  Array of steps in the Theme Panel
	 * 
	 * @return array  Modified array of steps with the 'Quick Setup' step added
	 */
	function yucca_options_qsetup_theme_panel_steps( $steps ) {
		if ( ! YUCCA_THEME_FREE ) {
			$steps = yucca_array_merge( $steps, array( 'qsetup' => esc_html__( 'Start customizing your theme.', 'yucca' ) ) );
		}
		return $steps;
	}
}


if ( ! function_exists( 'yucca_options_qsetup_theme_panel_tabs' ) ) {
	add_filter( 'trx_addons_filter_theme_panel_tabs', 'yucca_options_qsetup_theme_panel_tabs' );
	/**
	 * Add a tab link 'Quick Setup' to the Theme Panel tabs.
	 * 
	 * @hooked 'trx_addons_filter_theme_panel_tabs'
	 * 
	 * @param array $tabs  Array of tabs in the Theme Panel
	 * 
	 * @return array  Modified array of tabs with the 'Quick Setup' tab added
	 */
	function yucca_options_qsetup_theme_panel_tabs( $tabs ) {
		if ( ! YUCCA_THEME_FREE ) {
			yucca_array_insert_after( $tabs, 'plugins', array( 'qsetup' => esc_html__( 'Quick Setup', 'yucca' ) ) );
		}
		return $tabs;
	}
}

if ( ! function_exists( 'yucca_options_qsetup_add_accent_colors' ) ) {
	add_filter( 'yucca_filter_qsetup_options', 'yucca_options_qsetup_add_accent_colors' );
	/**
	 * Add accent colors to the 'Quick Setup' section in the Theme Panel
	 * 
	 * @hooked 'yucca_filter_qsetup_options'
	 * 
	 * @param array $options  Array of options in the 'Quick Setup' section
	 * 
	 * @return array  Modified array of options with accent colors added
	 */
	function yucca_options_qsetup_add_accent_colors( $options ) {
		$colors = apply_filters( 'yucca_filter_qsetup_colors', array(
			'text_link',
			'text_hover',
			'text_link2',
			'text_hover2',
			'text_link3',
			'text_hover3',
		) );
		if ( is_array( $colors ) && count( $colors ) > 0 ) {
			$names = yucca_storage_get( 'scheme_color_names' );
			$list = array(
				'colors_info'        => array(
					'title'    => esc_html__( 'Theme Colors', 'yucca' ),
					'desc'     => '',
					'qsetup'   => esc_html__( 'General', 'yucca' ),
					'type'     => 'info',
				),
			);
			foreach ( $colors as $color ) {
				if ( empty( $names[ $color ] ) ) {
					continue;
				}
				$list[ 'colors_' . yucca_get_scheme_color_name( $color ) ] = array(
					'title'    => esc_html( $names[ $color ]['title'] ),
					'desc'     => wp_kses_data( $names[ $color ]['description'] ),
					'std'      => '',
					'val'      => yucca_get_scheme_color( $color ),
					'qsetup'   => esc_html__( 'General', 'yucca' ),
					'type'     => 'color',
				);
			}
			$options = yucca_array_merge( $list, $options );
		}
		return $options;
	}
}

if ( ! function_exists( 'yucca_options_qsetup_theme_panel_section' ) ) {
	add_action( 'trx_addons_action_theme_panel_section', 'yucca_options_qsetup_theme_panel_section', 10, 2);
	/**
	 * Display 'Quick Setup' section in the Theme Panel
	 * 
	 * @hooked 'trx_addons_action_theme_panel_section'
	 * 
	 * @param string $tab_id  ID of the current tab
	 * @param array  $theme_info  Information about the theme
	 */
	function yucca_options_qsetup_theme_panel_section( $tab_id, $theme_info ) {
		if ( 'qsetup' !== $tab_id ) return;
		?>
		<div id="trx_addons_theme_panel_section_<?php echo esc_attr($tab_id); ?>" class="trx_addons_tabs_section">

			<?php do_action('trx_addons_action_theme_panel_section_start', $tab_id, $theme_info); ?>
			
			<div class="trx_addons_theme_panel_section_content trx_addons_theme_panel_qsetup">

				<?php do_action('trx_addons_action_theme_panel_before_section_title', $tab_id, $theme_info); ?>

				<h1 class="trx_addons_theme_panel_section_title">
					<?php esc_html_e( 'Quick Setup', 'yucca' ); ?>
				</h1>

				<?php do_action('trx_addons_action_theme_panel_after_section_title', $tab_id, $theme_info); ?>
				
				<div class="trx_addons_theme_panel_section_description">
					<p>
						<?php
						echo wp_kses_data( __( 'Here you can customize the basic settings of your website.', 'yucca' ) )
							. ' '
							. wp_kses_data( sprintf(
								__( 'For a detailed customization, go to %s.', 'yucca' ),
								'<a href="' . esc_url(admin_url() . 'customize.php') . '">' . esc_html__( 'Customizer', 'yucca' ) . '</a>'
								. ( YUCCA_THEME_FREE 
									? ''
									: ' ' . esc_html__( 'or', 'yucca' ) . ' ' . '<a href="' . esc_url( get_admin_url( null, 'admin.php?page=trx_addons_theme_panel' ) ) . '">' . esc_html__( 'Theme Options', 'yucca' ) . '</a>'
									)
								)
							);
						echo ' ' . wp_kses_data( __( "If you've imported the demo data, you may skip this step, since all the necessary settings have already been applied.", 'yucca' ) );
						?>
					</p>
				</div>

				<?php
				do_action('trx_addons_action_theme_panel_before_qsetup', $tab_id, $theme_info);

				yucca_options_qsetup_show();

				do_action('trx_addons_action_theme_panel_after_qsetup', $tab_id, $theme_info);

				do_action('trx_addons_action_theme_panel_after_section_data', $tab_id, $theme_info);
				?>

			</div>

			<?php do_action('trx_addons_action_theme_panel_section_end', $tab_id, $theme_info); ?>

		</div>
		<?php
	}
}

if ( ! function_exists( 'yucca_options_qsetup_show' ) ) {
	/**
	 * Display options in the 'Quick Setup' section of the Theme Panel.
	 */
	function yucca_options_qsetup_show() {
		$tabs_titles  = array();
		$tabs_content = array();
		$options      = apply_filters( 'yucca_filter_qsetup_options', yucca_storage_get( 'options' ) );
		// Show fields
		$cnt = 0;
		foreach ( $options as $k => $v ) {
			if ( empty( $v['qsetup'] ) ) {
				continue;
			}
			if ( is_bool( $v['qsetup'] ) ) {
				$v['qsetup'] = esc_html__( 'General', 'yucca' );
			}
			if ( ! isset( $tabs_titles[ $v['qsetup'] ] ) ) {
				$tabs_titles[ $v['qsetup'] ]  = $v['qsetup'];
				$tabs_content[ $v['qsetup'] ] = '';
			}
			if ( 'info' !== $v['type'] ) {
				$cnt++;
				if ( ! empty( $v['class'] ) ) {
					$v['class'] = str_replace( array( 'yucca_column-1_2', 'yucca_new_row' ), '', $v['class'] );
				}
				$v['class'] = ( ! empty( $v['class'] ) ? $v['class'] . ' ' : '' ) . 'yucca_column-1_2' . ( $cnt % 2 == 1 ? ' yucca_new_row' : '' );
			} else {
				$cnt = 0;
			}
			$tabs_content[ $v['qsetup'] ] .= yucca_options_show_field( $k, $v );
		}
		if ( count( $tabs_titles ) > 0 ) {
			?>
			<div class="yucca_options yucca_options_qsetup">
				<form action="<?php echo esc_url( get_admin_url( null, 'admin.php?page=trx_addons_theme_panel' ) ); ?>" class="trx_addons_theme_panel_section_form" name="trx_addons_theme_panel_qsetup_form" method="post">
					<input type="hidden" name="qsetup_options_nonce" value="<?php echo esc_attr( wp_create_nonce( admin_url() ) ); ?>" />
					<?php
					if ( count( $tabs_titles ) > 1 ) {
						?>
						<div id="yucca_options_tabs" class="yucca_tabs">
							<ul>
								<?php
								$cnt = 0;
								foreach ( $tabs_titles as $k => $v ) {
									$cnt++;
									?>
									<li><a href="#yucca_options_<?php echo esc_attr( $cnt ); ?>"><?php echo esc_html( $v ); ?></a></li>
									<?php
								}
								?>
							</ul>
							<?php
							$cnt = 0;
							foreach ( $tabs_content as $k => $v ) {
								$cnt++;
								?>
								<div id="yucca_options_<?php echo esc_attr( $cnt ); ?>" class="yucca_tabs_section yucca_options_section">
									<?php yucca_show_layout( $v ); ?>
								</div>
								<?php
							}
							?>
						</div>
						<?php
					} else {
						?>
						<div class="yucca_options_section">
							<?php yucca_show_layout( yucca_array_get_first( $tabs_content, false ) ); ?>
						</div>
						<?php
					}
					?>
					<div class="yucca_options_buttons trx_buttons">
						<a href="#" role="button" class="yucca_options_button_submit trx_addons_button trx_addons_button_accent" tabindex="0"><?php esc_html_e( 'Save Options', 'yucca' ); ?></a>
					</div>
				</form>
			</div>
			<?php
		}
	}
}


if ( ! function_exists( 'yucca_options_qsetup_save_options' ) ) {
	add_action( 'after_setup_theme', 'yucca_options_qsetup_save_options', 4 );
	/**
	 * Merge a 'Quick setup' options with the Theme Options and save them.
	 * 
	 * @hooked 'after_setup_theme'
	 */
	function yucca_options_qsetup_save_options() {

		if ( ! isset( $_REQUEST['page'] ) || 'trx_addons_theme_panel' != $_REQUEST['page'] || '' == yucca_get_value_gp( 'qsetup_options_nonce' ) ) {
			return;
		}

		// verify nonce
		if ( ! wp_verify_nonce( yucca_get_value_gp( 'qsetup_options_nonce' ), admin_url() ) ) {
			trx_addons_set_admin_message( esc_html__( 'Bad security code! Options are not saved!', 'yucca' ), 'error', true );
			return;
		}

		// Check permissions
		if ( ! current_user_can( 'manage_options' ) ) {
			trx_addons_set_admin_message( esc_html__( 'Manage options is denied for the current user! Options are not saved!', 'yucca' ), 'error', true );
			return;
		}

		// Prepare colors for Theme Options
		$scheme_storage = get_theme_mod( 'scheme_storage' );
		if ( empty( $scheme_storage ) ) {
			$scheme_storage = yucca_get_scheme_storage();
		}
		if ( ! empty( $scheme_storage ) ) {
			$schemes = yucca_unserialize( $scheme_storage );
			if ( is_array( $schemes ) ) {
				$main_scheme = yucca_storage_get_array( 'schemes_sorted', 0 );
				if ( empty( $main_scheme ) ) {
					$main_scheme = 'default';
				}
				$color_scheme = get_theme_mod( $main_scheme, yucca_storage_get_array( 'options', $main_scheme, 'std' ) );
				if ( empty( $color_scheme ) ) {
					$color_scheme = yucca_array_get_first( $schemes );
				}
				if ( ! empty( $schemes[ $color_scheme ] ) ) {
					$schemes_simple = yucca_storage_get( 'schemes_simple' );
					// Get posted data and calculate substitutions
					$need_save = false;
					foreach ( $schemes[ $color_scheme ][ 'colors' ] as $k => $v ) {
						$v2 = yucca_get_value_gp( "yucca_options_field_colors_{$k}" );
						if ( ! empty( $v2 ) && $v != $v2 ) {
							$schemes[ $color_scheme ][ 'colors' ][ $k ] = $v2;
							$need_save = true;
							// Сalculate substitutions
							if ( isset( $schemes_simple[ $k ] ) && is_array( $schemes_simple[ $k ] ) ) {
								foreach ( $schemes_simple[ $k ] as $color => $level ) {
									$new_v2 = $v2;
									// Make color_value darker or lighter
									if ( 1 != $level ) {
										$hsb = yucca_hex2hsb( $new_v2 );
										$hsb[ 'b' ] = min( 100, max( 0, $hsb[ 'b' ] * ( $hsb[ 'b' ] < 70 ? 2 - $level : $level ) ) );
										$new_v2 = yucca_hsb2hex( $hsb );
									}
									$schemes[ $color_scheme ][ 'colors' ][ $color ] = $new_v2;
								}
							}
						}
					}
					// Put new values to the POST
					if ( $need_save ) {
						$_POST[ 'yucca_options_field_scheme_storage' ] = serialize( $schemes );
					}
				}
			}
		}

		// Save options
		yucca_options_update( null, 'yucca_options_field_' );

		// Return result
		trx_addons_set_admin_message( esc_html__( 'Options are saved', 'yucca' ), 'success', true );
		wp_redirect( get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_qsetup' ) );
		exit();
	}
}
