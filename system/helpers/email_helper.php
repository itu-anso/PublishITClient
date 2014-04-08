<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Email Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/email_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Validate email address
 *
 * @access	public
 * @return	bool
 */
if ( ! function_exists('valid_email'))
{
	function valid_email($address)
	{
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $address)) ? FALSE : TRUE;
	}
}

// ------------------------------------------------------------------------

/**
 * Send an email
 *
 * @access	public
 * @return	bool
 */
if ( ! function_exists('send_email'))
{
	function send_email($recipient, $subject = 'Test email', $message = 'Hello World')
	{
		date_default_timezone_set('Europe/Paris');
		$ci = & get_instance();
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
		$headers .= "Content-Transfer-Encoding: 7bit\r\n";
		$headers .= "X-Priority: 3\r\n";
		$headers .= "X-Mailer: PHP" . phpversion() . "\r\n";
		
		$headers .= "Reply-To: Bakkely.dk <mailboks@bakkely.dk>\r\n";
		$headers .= "Return-Path: Bakkely development <development@bakkely.dk>\r\n";
		$headers .= "From: Bakkely.dk <no-reply@bakkely.dk>\r\n";
		$headers .= "Organization: Bakkely.dk\r\n";
		
		$subject = "=?UTF-8?B?".base64_encode($subject)."?=";
		$message .= " \r\n";
		
		$query = "
			INSERT INTO email (recipient, headers, subject, content, send_time)
				VALUES(?, ?, ?, ?, CURRENT_TIMESTAMP)";
		$ci->db->query($query, array($recipient, $headers, $subject, $message));
		mail($recipient, $subject, $message, $headers);
	}
}

/* End of file email_helper.php */
/* Location: ./system/helpers/email_helper.php */