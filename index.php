<?php 
/*
Project Name: UF CLAS PHP Email CAPTCHA Form
Project URI: https://it.clas.ufl.edu/
Description: Sends form submission and confirmation messages then redirects to a confirmation page. Uses Google reCAPTCHA API to avoid spam submissions.
Version: 2.0.0
Author: Priscilla Chapman (CLAS IT)
Author URI: https://it.clas.ufl.edu/
Build Date: 20161010
*/
// Include required functions
include 'inc/functions.php';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset( $_POST['submit'] ) ){
    
    if ( $email_form->validate() ){
    
        // Set sender email from form field
        $user_email = $email_form->get_sender_email();
        $admin_email->from = $confirm_email->to = $user_email;
                
        // Send admin and confirmation messages with form data
        $admin_email->send_email( $email_form );
        $confirm_email->send_email( $email_form );
        
        // Redirect to confirmation if email sent
        if( $admin_email->sent && $confirm_email->sent ){
            header('Location: confirmation.php');
            exit;
        }
        else {
            $email_form->errors[] = "Error: Could not send form email. Please try again.";
        }
    }
}

include FORM_PROJECT_PATH . '/inc/header.php';
include FORM_PROJECT_PATH . '/content/form.php';

$email_form->display();

include FORM_PROJECT_PATH . '/inc/footer.php';
?>
