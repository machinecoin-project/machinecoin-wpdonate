<?php
/*
Plugin Name: WP-MachineCoin
Plugin URI: http://idienstler.de/plugins/wp-machinecoin
Description: This plugin allows you to add your Machinecoin donation address to the bottom of your blog posts - automatically!
Version: 1.2
Author: Jürgen Scholz
Author URI: http://idienstler.de
Author Email: j.scholz@idienstler.de
License: GPL 3.0
License URI: http://www.gnu.org/licenses/gpl.html
*/

// Adds the wallet address to the end of the post content.
add_filter ('the_content', 'WPMachineCoinContent');

function WPMachineCoinContent($content) {
	if (get_option('wpmc_wallet_address') == true) {
		$content .= '<div class="wpmc_box">';
		$content .= 'Spende Machinecoins: <strong>';
		$content .= get_option('wpmc_wallet_address');
		$content .= '</strong> ';
		$content .= '<span class="wpmc_small"><a href="http://machinecoin.de/" target="_blank">Was ist das?</a></span>';
		$content .= '</div>';
		return $content;
	} else {
		return $content;
	}
}

// stylesheet for the donation bar
    add_action( 'wp_enqueue_scripts', 'safely_add_stylesheet' );
    
    function safely_add_stylesheet() {
        wp_enqueue_style( 'wp-machinecoin', plugins_url('wp-machinecoin.css', __FILE__) );
    }
// create custom plugin settings menu
add_action('admin_menu', 'wpmc_create_menu');

function wpmc_create_menu() {

	//create new top-level menu
	add_menu_page('WPMC Plugin Settings', 'WPMC Settings', 'administrator', __FILE__, 'wpmc_settings_page',plugins_url('/wp-machinecoin-icon.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
	//register our settings
	register_setting( 'wpmc-settings-group', 'wpmc_wallet_address' );
}

function wpmc_settings_page() {
?>
<div class="wrap">
<h2>WP-Machinecoin Settings</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'wpmc-settings-group' ); ?>
    <?php do_settings_sections( 'wpmc-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Wallet Address</th>
        <td><input type="text" name="wpmc_wallet_address" value="<?php echo get_option('wpmc_wallet_address'); ?>" /></td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>

<p>Plugin written and supported by <a href="http://idienstler.de" target="_blank">Jürgen Scholz</a>.  You can send donations to <strong>MDSQf1PSdrpTBE8GGV4ydhAqq9z5AbMDAw</strong> if you like what you see!</p>
</div>
<?php } ?>
