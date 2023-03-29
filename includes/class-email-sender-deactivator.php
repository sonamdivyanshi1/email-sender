<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://sonam.wisdmlabs.net
 * @since      1.0.0
 *
 * @package    Email_Sender
 * @subpackage Email_Sender/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Email_Sender
 * @subpackage Email_Sender/includes
 * @author     Sonam Divyanshi <sonam.divyanshi@wisdmlabs.com>
 */
class Email_Sender_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		wp_clear_scheduled_hook('email_event');
	}

}
