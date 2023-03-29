<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://sonam.wisdmlabs.net
 * @since      1.0.0
 *
 * @package    Email_Sender
 * @subpackage Email_Sender/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Email_Sender
 * @subpackage Email_Sender/admin
 * @author     Sonam Divyanshi <sonam.divyanshi@wisdmlabs.com>
 */
class Email_Sender_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Email_Sender_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Email_Sender_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/email-sender-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Email_Sender_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Email_Sender_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/email-sender-admin.js', array( 'jquery' ), $this->version, false );

	}

	function custom_cron_schedules($schedules)
	{
		if (!isset($schedules['1minute'])) {
			$schedules['1minute'] = array(
				'interval' => 60,
				'display' => __('Once every minute')
			);
		}

		return $schedules;
	}
	
	public function send_daily_post_details()
	{
		$to = get_option('admin_email');
		$subject = 'Daily Post Details';
		$args = array(
			'date_query' => array(
				array(
					'after' => '24 hours ago',
				),
			),
		);

		$query = new WP_Query($args);
		$posts = $query->posts;
		$message = '';

		if (count($posts) == 0) {
			return;
		}

		foreach ($posts as $post) {

			$meta_title_of_post = get_post_meta($post->ID, '_yoast_wpseo_title', true);
			if (empty($meta_description)) {
				$meta_title_of_post = "No Meta title found";
			}

			$meta_description = get_post_meta($post->ID, '_yoast_wpseo_metadesc', true);
			if (empty($meta_description)) {
				$meta_description = "No meta description available";
			}

			$meta_keywords = get_post_meta($post->ID, '_yoast_wpseo_focuskw', true);
			if (empty($meta_keywords)) {
				$meta_keywords = "No meta keywords available";
			}

			$page_speed_score = $this->get_page_speed_score(get_permalink($post->ID));

			$message .= 'Post Title: ' . $post->post_title . "\n";
			$message .= 'Post URL: ' . get_permalink($post->ID) . "\n";
			$message .= 'Meta Title: ' . $meta_title_of_post . "\n";
			$message .= 'Meta Description: ' . $meta_description . "\n";
			$message .= 'Meta Keywords: ' . $meta_keywords . "\n";
			$message .= 'Page Speed Score: ' . $page_speed_score . " seconds \n";
			$message .= "\n";
		}

		$headers = array(
			'From: sonam.divyanshi@wisdmlabs.com',
		);

		wp_mail($to, $subject, $message, $headers);
	}


}
