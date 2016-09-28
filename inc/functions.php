<?php 
/*
Project Name: UF CLAS Custom Form-to-Email
Project URI: http://it.clas.ufl.edu/
Description: Sends a form to email then redirect to a confirmation page. Avoids spam and multiple submissions.
Version: 1.1.0
Author: Priscilla Chapman (CLAS IT)
Author URI: http://it.clas.ufl.edu/
Build Date: 20130928
License: GPL2
*/

// Project constants    
define('PROJECT_NAME', 'Call for Proposals' );
define('PROJECT_DEBUG', false );
define('HOME_PATH', dirname( dirname(__FILE__) ) ); // No trailing slash
define('HOME_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/' . basename(dirname($_SERVER['PHP_SELF'])) );
define('FORM_CAPTCHA_SITEKEY', '6Lf1UAcUAAAAADPggsA_poVLfN0CkqOlsymfGRsr' );
define('FORM_CAPTCHA_SECRET', '6Lf1UAcUAAAAAL4-r_Rt_wOn5qiPI9We-8H0FPQ6' );
define('FORM_EMAIL_ADMIN_NAME', 'Center for the Humanities and the Public Sphere' );
define('FORM_EMAIL_ADMIN_EMAIL', 'humanities-center@ufl.edu' );
define('FORM_EMAIL_SUBJECT', 'Public Humanities Statement of Intent 2016-2017' );

include HOME_PATH . '/inc/class.form.php';
include HOME_PATH . '/inc/class.field.php';
include HOME_PATH . '/inc/class.email_message.php';

// Set email message defaults
$admin_email = new Email_Message( array(
    'to' => sprintf('%s <%s>', FORM_EMAIL_ADMIN_NAME, FORM_EMAIL_ADMIN_EMAIL),
    'from' => '',
    'subject' => "Submission: " . FORM_EMAIL_SUBJECT,
    'excluded_fields' => array('submit', 'g-recaptcha-response'),
) );
$confirm_email = new Email_Message( array(
    'to' => '',
    'from' => sprintf('%s <%s>', FORM_EMAIL_ADMIN_NAME, FORM_EMAIL_ADMIN_EMAIL),
    'subject' => "Confirmation: " . FORM_EMAIL_SUBJECT,
    'excluded_fields' => array('submit', 'g-recaptcha-response'),
) );

// Set form fields
$email_fields = array(
    new Text_Field( array(
        'title' => 'University of Florida Co-Applicant Name(s) and Affiliation(s)',
        'id' => '01applicant1',
        'default' => '',
        'required' => true,
    )),
    new Email_Field( array(
        'title' => 'Email Address of Corresponding University of Florida Co-Applicant',
        'id' => '01email',
        'default' => '',
        'required' => true,
    )),
    new Textarea_Field( array(
        'title' => 'Biographical description of University of Florida Co-Applicant',
        'id' => '02description',
        'required' => true,
    )),
    new Text_Field( array(
        'title' => 'Community Co-Applicant Name(s) and Affiliation(s)',
        'id' => '02applicant2',
        'required' => true,
    )),
    new Email_Field( array(
        'title' => 'Email Address of Corresponding University of Florida Co-Applicant',
        'id' => '02email',
        'required' => true,
    )),
    new Textarea_Field( array(
        'title' => 'Biographical description of University of Florida Co-Applicant',
        'id' => '03description',
        'required' => true,
    )),
    new Textarea_Field( array(
        'title' => 'Please provide a description of the aim of the project and budgetary needs in no more than 300 words.',
        'id' => '04description',
        'required' => true,
    )),
    new Captcha_Field( array(
        'title' => 'Verification',
        'id' => 'g-recaptcha-response',
        'url' => 'https://www.google.com/recaptcha/api/siteverify',
        'sitekey' => FORM_CAPTCHA_SITEKEY,
        'secret' => FORM_CAPTCHA_SECRET,
    )),
);

$email_form = new Form( array(
    'id' => 'email-form',
    'action' => HOME_URL . '/index.php',
    'fields' => $email_fields,
));



?>