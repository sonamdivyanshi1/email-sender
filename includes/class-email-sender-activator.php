<?php

/**
 * Fired during plugin activation
 *
 * @link       https://sonam.wisdmlabs.net
 * @since      1.0.0
 *
 * @package    Email_Sender
 * @subpackage Email_Sender/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Email_Sender
 * @subpackage Email_Sender/includes
 * @author     Sonam Divyanshi <sonam.divyanshi@wisdmlabs.com>
 */
class Email_Sender_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		if (!wp_next_scheduled('email_event')) {
			wp_schedule_event(strtotime('23:59'), 'hourly', 'email_event');
		  }
		  

	}

}
