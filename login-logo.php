<?php
/*
Plugin Name: Login Logo
Description: Drop a PNG file named <code>login-logo.png</code> into your <code>wp-content</code> directory. This simple plugin takes care of the rest, with zero configuration. Transparent backgrounds work best. Crop it tight, with a width of 312 pixels, for best results.
Version: 0.7
License: GPL
Plugin URI: http://txfx.net/wordpress-plugins/login-logo/
Author: Mark Jaquith
Author URI: http://coveredwebservices.com/

==========================================================================

Copyright 2011-2012  Mark Jaquith

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

class CWS_Login_Logo_Plugin {
	static $instance;
	const CUTOFF = 312;
	var $logo_locations;
	var $logo_location;
	var $width = 0;
	var $height = 0;
	var $original_width;
	var $original_height;
	var $logo_size;
	var $logo_file_exists;

	public function __construct() {
		self::$instance = $this;
		add_action( 'login_head', array( $this, 'login_head' ) );
	}

	public function init() {
		global $blog_id;
		$this->logo_locations = array();
		if ( is_multisite() && function_exists( 'get_current_site' ) ) {
			// First, see if there is one for this specific site (blog)
			$this->logo_locations['site'] = array(
				'path' => WP_CONTENT_DIR . '/login-logo-site-' . $blog_id . '.png',
				'url' => $this->maybe_ssl( content_url( 'login-logo-site-' . $blog_id . '.png' ) )
			);

			// Next, we see if there is one for this specific network
			$site = get_current_site(); // Site = Network? Ugh.
			if ( $site && isset( $site->id ) ) {
				$this->logo_locations['network'] = array(
					'path' => WP_CONTENT_DIR . '/login-logo-network-' . $site->id . '.png',
					'url' => $this->maybe_ssl( content_url( 'login-logo-network-' . $site->id . '.png' ) )
					);
			}
		}
		// Finally, we do a global lookup
		$this->logo_locations['global'] =  array(
			'path' => WP_CONTENT_DIR . '/login-logo.png',
			'url' => $this->maybe_ssl( content_url( 'login-logo.png' ) )
			);
	}

	private function maybe_ssl( $url ) {
		if ( is_ssl() )
			$url = preg_replace( '#^http://#', 'https://', $url );
		return $url;
	}

	private function logo_file_exists() {
		if ( ! isset( $this->logo_file_exists ) ) {
			foreach ( $this->logo_locations as $location ) {
				if ( file_exists( $location['path'] ) ) {
					$this->logo_file_exists = true;
					$this->logo_location = $location;
					break;
				} else {
					$this->logo_file_exists = false;
				}
			}
		}
		return !! $this->logo_file_exists;
	}

	private function get_location( $what = '' ) {
		if ( $this->logo_file_exists() ) {
			if ( 'path' == $what )
				return $this->logo_location[$what];
			elseif ( 'url' == $what )
				return $this->logo_location[$what] . '?v=' . filemtime( $this->logo_location['path'] );
			else
				return $this->logo_location;
		}
		return false;
	}

	private function get_width() {
		$this->get_logo_size();
		return absint( $this->width );
	}

	private function get_height() {
		$this->get_logo_size();
		return absint( $this->height );
	}

	private function get_original_width() {
		$this->get_logo_size();
		return absint( $this->original_width );
	}

	private function get_original_height() {
		$this->get_logo_size();
		return absint( $this->original_height );
	}

	private function get_logo_size() {
		if ( !$this->logo_file_exists() )
			return false;
		if ( !$this->logo_size ) {
			if ( $sizes = getimagesize( $this->get_location( 'path' ) ) ) {
				$this->logo_size = $sizes;
				$this->width  = $sizes[0];
				$this->height = $sizes[1];
				$this->original_height = $this->height;
				$this->original_width = $this->width;
				if ( $this->width > self::CUTOFF ) {
					// Use CSS 3 scaling
					$ratio = $this->height / $this->width;
					$this->height = ceil( $ratio * self::CUTOFF );
					$this->width = self::CUTOFF;
				}
			} else {
				$this->logo_file_exists = false;
			}
		}
		return array( $this->width, $this->height );
	}

	private function css3( $rule, $value ) {
		foreach ( array( '', '-o-', '-webkit-', '-khtml-', '-moz-', '-ms-' ) as $prefix ) {
			echo $prefix . $rule . ': ' . $value . '; ';
		}
	}

	public function login_headerurl() {
		return esc_url( trailingslashit( get_bloginfo( 'url' ) ) );
	}

	public function login_headertitle() {
		return esc_attr( get_bloginfo( 'name' ) );
	}

	public function login_head() {
		$this->init();
		if ( !$this->logo_file_exists() )
			return;
		add_filter( 'login_headerurl', array( $this, 'login_headerurl' ) );
		add_filter( 'login_headertitle', array( $this, 'login_headertitle' ) );
	?>
	<!-- Login Logo plugin for WordPress: http://txfx.net/wordpress-plugins/login-logo/ -->
	<style type="text/css">
		.login h1 a {
			background: url(<?php echo esc_url_raw( $this->get_location( 'url' ) ); ?>) no-repeat top center;
			width: <?php echo self::CUTOFF; ?>px;
			height: <?php echo $this->get_height(); ?>px;
			margin-left: 8px;
			padding-bottom: 16px;
			<?php
			if ( self::CUTOFF < $this->get_original_width() )
				$this->css3( 'background-size', 'contain' );
			else
				$this->css3( 'background-size', 'auto' );
			?>
		}
	</style>
<?php if ( self::CUTOFF < $this->get_width() ) { ?>
<!--[if lt IE 9]>
	<style type="text/css">
		height: <?php echo $this->get_original_height() + 3; ?>px;
	</style>
<![endif]-->
<?php
		}
	}

}

// Bootstrap
new CWS_Login_Logo_Plugin;
