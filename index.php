<?php 
// Include required functions
include 'inc/functions.php';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset( $_POST['submit'] ) ){
    
    if ( $email_form->validate() ){
    
        // Set sender email from form field
        $admin_email->from = $confirm_email->to = $email_form->get_field_value('01email');
                
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

include HOME_PATH . '/inc/header.php';
include HOME_PATH . '/content/form.html';

$email_form->display();

include HOME_PATH . '/inc/footer.php';
?>
