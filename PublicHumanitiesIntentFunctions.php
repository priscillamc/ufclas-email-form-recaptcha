<?php 
	/*
	Project Name: UF CLAS Custom Form-to-Email
	Project URI: http://it.clas.ufl.edu/
	Description: Sends a form to email then redirect to a confirmation page. Avoids spam and multiple submissions.
	Version: 0.1.0
	Author: Priscilla Chapman (CLAS IT)
	Author URI: http://it.clas.ufl.edu/
	License: GPL2
	*/
	
	session_start();
	
	// Initialize variables
	$errors = array();
	$sent = ( isset($_SESSION['sent']) )? $_SESSION['sent']:false;
	$token = ( isset($_SESSION['token']) )? $_SESSION['token']:set_session_token();
	$honeypot = 'Business_Email';
	
	// Check is valid request, honeypot field is empty
	if( ($_SERVER['REQUEST_METHOD'] == 'POST') ){
		if( ($_POST['token'] == $_SESSION['token']) && !strlen($_POST[$honeypot])  ){
			// Check if not already sent
			if(!$sent || $resubmit){			
				// Validate
				validate_form();
				
				// Send Email if no errors found
				if( count($errors) == 0 ){
					$user_email = filter_var($_SESSION[$user_email_field], FILTER_SANITIZE_EMAIL);
					$sent = send_email_message( $admin_email, $user_email, $admin_email_subject, format_email_message($admin_email_message) );
					if($sent){
						// Send user confirmation message with form data
						$confirm = send_email_message( $user_email, $admin_email, $confirmation_email_subject, format_email_message($confirmation_email_message) );
						$_SESSION['sent'] = $confirm;
						
						if($confirm){
							// Redirect to confirmation if email sent
							header('Location: '. $confirmation_url);
							exit;
						}
					}
					else {
						$errors[0] = "Error: Could not send form. Please try again.";
					}
				}
			}
			else {
				// Form already sent, if user hits the back and submits
				$errors[0] = 'Notice: This form has already been submitted. Please restart your browser and try again.';
			}
		}
		else {
			// Form token or honeypot invalid
			$errors[0] = 'Notice: Invalid Form Submission. Please restart your browser and try again.';
		}
	}
	$_SESSION['errors'] = $errors;
	
	// Functions
	function set_session_token() {
		$_SESSION['token'] = md5(uniqid(mt_rand(),true));
		return $_SESSION['token'];
	}
	function display_error_message() {
		if( isset($_SESSION['errors']) && count($_SESSION['errors']) > 0 ){
			echo '<div id="errors"><p><strong>Please correct the following errors in this form:</strong></p><ul>';
			foreach($_SESSION['errors'] as $key => $val) {
				echo '<li>' . $val . '</li>';
			}
			echo '</ul></div>';
		}
	}
	function display_value( $field_name ){
		$value = ( isset($_SESSION[$field_name]) )? $_SESSION[$field_name]:'';
		$display = sanitize($value);
		echo $display;
	}
	function display_checked( $field_name, $option_value ){
		// determine if a radio or checkbox is selected
		$checked = "";
		if( isset($_SESSION[$field_name]) ){
			if( $_SESSION[$field_name] == $option_value ){
				$checked = "checked";
			}
		}
		echo $checked;
	}
	function display_honeypot_field() {
		global $honeypot;
		display_form_styles();
		echo '<label id="' . $honeypot . '"><input name="' . $honeypot . '"></label>';
	}
	function display_form_styles() {
		global $honeypot;
		echo '<style>';
		echo 'label#' . $honeypot. ' {display:none;}';
		echo '#errors {margin:1em;padding:1em;background-color:#FFF8CF;border:1px solid #EFCA00;border-radius:5px;}';
		echo '</style>';
	}
	function sanitize( $str ){
		if(!is_array($str)){
			// Remove all html tags and convert special characters
			$clean = strip_tags(trim($str));
			$clean = htmlentities($clean, ENT_NOQUOTES, 'UTF-8');
			
			// Allow certain characters
			$ents = array("&mdash;","&ndash;","&amp; ","&nbsp;");
			$allowed_ents = array(" - "," - ","& "," ");
			$clean = str_replace($ents, $allowed_ents, $clean);
		}
		else {
			foreach($str as $key => $val){
				$str[$key] = sanitize($val);
			}
			$clean = $str;
		}
		return $clean;
	}
	
	function validate_form(){
		global $errors, $required_single, $required_email, $required_multiple;
		
		// Save the values into the session
		$_SESSION = array_merge($_SESSION, $_POST);
		
		// Validate fields
		if( !empty($required_single) ){
			foreach( $required_single as $field_name => $field_label){
				if( !isset($_SESSION[$field_name]) || !strlen($_SESSION[$field_name]) ){
					$errors[$field_name] = "<strong>{$field_label}</strong> is required.";
				}
			}
		}
		if( !empty($required_multiple) ){
			foreach( $required_multiple as $field_name => $field_label ){
				if( !isset($_SESSION[$field_name]) || count($_SESSION[$field_name]) == 0 ){
					$errors[$field_name] = "<strong>{$field_label}</strong> is required.";
				}
			}
		}
		if( !empty($required_email) ){
			foreach( $required_email as $field_name  => $field_label){
				if (!filter_var($_SESSION[$field_name], FILTER_VALIDATE_EMAIL)) {
					$errors[$field_name] = "<strong>{$field_label}</strong> is not a valid email address.";
				}
			}
		}
	}
	function format_email_message($email_message) {
		global $honeypot;
		$excluded = array('token', 'submit', $honeypot, 'errors', 'sent');
		
		// Sort and add all fields to the message
		$form_fields = "\n";
		ksort($_SESSION);
		foreach($_SESSION as $key => $val){
			$str = (is_array($val))? join(', ', $val):$val;
			if( !in_array($key, $excluded) ){
				$form_fields .= "[{$key}]: \t" . sanitize($str) . "\n";
			}
		}
		$message = str_replace( 'FORM_FIELDS', $form_fields, $email_message );
		$message = str_replace( 'IP_ADDRESS', $_SERVER['SERVER_ADDR'], $message );
		return $message;
	}

	function send_email_message($to, $from, $subject, $message) {
		global $admin_name;
		$headers = "From: {$admin_name} <{$admin_email}>" . "\r\n" .
		"Reply-To: $from" . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
		
		$sent = mail($to, $subject, $message, $headers);
		return $sent;
	}
?>