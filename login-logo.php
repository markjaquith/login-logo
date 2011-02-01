<?php
/*
Plugin Name: Login Logo
Description: Drop a PNG file named <code>login-logo.png</code> into your <code>wp-content</code> directory. This simple plugin takes care of the rest, with zero configuration. Transparent backgrounds work best. Keep the width below 326 pixels.
Version: 0.1
License: GPL
Author: Mark Jaquith
Author URI: http://coveredwebservices.com/
*/

class CWS_Login_Logo_Plugin {
	static $instance;
	var $logo_path;
	var $logo_url;
	var $width = 0;
	var $height = 0;
	var $original_height;
	var $logo_size;
	var $logo_file_exists;

	public function __construct() {
		self::$instance = $this;
		$this->add_hooks();
	}

	private function add_hooks() {
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'login_head', array( $this, 'login_head' ) );
	}

	public function init() {
		$this->logo_path = WP_CONTENT_DIR . '/login-logo.png';
		$this->logo_url  = WP_CONTENT_URL . '/login-logo.png';
	}

	private function logo_file_exists() {
		if ( ! isset( $this->logo_file_exists ) )
			$this->logo_file_exists = !! file_exists( $this->logo_path );
		return !! $this->logo_file_exists;
	}

	private function get_width() {
		$this->get_logo_size();
		return absint( $this->width );
	}

	private function get_height() {
		$this->get_logo_size();
		return absint( $this->height );
	}

	private function get_original_height() {
		$this->get_logo_size();
		return absint( $this->original_height );
	}

	private function get_logo_size() {
		if ( !$this->logo_file_exists() )
			return false;
		if ( !$this->logo_size ) {
			if ( $sizes = getimagesize( $this->logo_path ) ) {
				$this->logo_size = $sizes;
				$this->width  = $sizes[0];
				$this->height = $sizes[1];
				$this->original_height = $this->height;
				if ( $this->width > 326 ) {
					// Use CSS 3 scaling
					$ratio = $this->height / $this->width;
					$this->height = ceil( $ratio * 326 );
					$this->width = 326;
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

	public function login_head() {
	?>
	<!-- Login Logo plugin for WordPress: http://txfx.net/wordpress-plugins/login-logo/ -->
	<style type="text/css">
		h1 a {
			background: url(<?php echo esc_url_raw( $this->logo_url ); ?>) no-repeat top center;
			width: 326px;
			height: <?php echo $this->get_height() + 3; ?>px;
			<?php $this->css3( 'background-size', 'contain' ); ?>
		}
	</style>
<!--[if lt IE 9]>
	<style type="text/css">
		height: <?php echo $this->get_original_height() + 3; ?>px;
	</style>
<![endif]-->
<?php
	}

}

// Bootstrap
new CWS_Login_Logo_Plugin;
