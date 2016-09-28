<?php 
// Include required functions
include 'inc/functions.php';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset( $_POST['submit'] ) ){
    
    if ( $email_form->validate() ){
    
        // Set sender email
        $sender_email = $email_form->get_field_value('01email');
        $admin_email['from'] = $sender_email;
        $confirm_email['to'] = $sender_email;
        
        // Send admin and confirmation message with form data
        $admin_sent = $email_form->send_email( $admin_email );
        $confirm_sent = $email_form->send_email( $confirm_email );
        
        // Redirect to confirmation if email sent
        if( $admin_sent && $confirm_sent ){
            header('Location: confirmation.php');
            exit;
        }
        else {
            $email_form->errors[] = "Error: Could not send form email. Please try again.";
        }
    }
    if ( PROJECT_DEBUG ){
        error_log( 'POST: ' . print_r($_POST, true) );
    }
}

include HOME_PATH . '/inc/header.php';
?>
        
<!-- start content -->   

<h1>Call for Proposals 2017-2018</h1>
<span class="Apple-style-span" style="color: rgb(34, 34, 34); background-color: rgb(186, 193, 169); font-size: medium;"></span>
<h2><span style="font-family: Georgia,&quot;Times New Roman&quot;,Times,serif;"></span>Public Humanities — Statement of Intent — Deadline: 10 February 2017 (5:00pm EST)</h2>
<p>In order to encourage and enhance collaborations between the University of Florida and off-campus individuals, groups, and institutions, the Center will offer grants up to $3,000 to support public programs rooted in one or more of the humanities disciplines. The Center intends to foster, support, and publicize humanities initiatives that engage the public in thoughtful and informed dialogues outside of the UF campus between May 1, 2016 and May 1, 2017. These programs will draw on the human expertise of both UF and community partners. To submit a statement of intent to this program, please fill out the required fields below, and click "submit" to receive a confirmation of your submission by email.</p>

<p>Any queries about this program may be sent to the Center Director, Prof. Bonnie Effros, at <a href="mailto:humanities-center@ufl.edu">humanities-center@ufl.edu</a>.</p>

<?php $email_form->display(); ?>

<!-- end content -->
<?php //} ?>
<?php include HOME_PATH . '/inc/footer.php'; ?>