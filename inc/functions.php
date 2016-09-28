<?php 
/*
Project Name: UF CLAS Custom Form-to-Email
Project URI: http://it.clas.ufl.edu/
Description: Sends a form to email then redirect to a confirmation page. Avoids spam and multiple submissions.
Version: 1.0.0
Author: Priscilla Chapman (CLAS IT)
Author URI: http://it.clas.ufl.edu/
Build Date: 20130927
License: GPL2
*/

// Project constants    
define('PROJECT_NAME', 'Call for Proposals' );
define('PROJECT_DEBUG', false );
define('HOME_PATH', dirname( dirname(__FILE__) ) ); // No trailing slash
define('HOME_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/' . basename(dirname($_SERVER['PHP_SELF'])) );

include HOME_PATH . '/inc/class.form.php';
include HOME_PATH . '/inc/class.field.php';

$admin_email = array(
    'to' => 'Center for the Humanities and the Public Sphere <humanities-center@ufl.edu>',
    'subject' => 'Submission: Public Humanities Statement of Intent 2016-2017',
    'message' => "Submission of letter of intent to the Public Humanities funding program at the UF Center for the Humanities and the Public Sphere:\n\nFORM_FIELDS",
);

$confirm_email = array(
    'from' => 'Center for the Humanities and the Public Sphere <humanities-center@ufl.edu>',
    'subject' => 'Confirmation: Public Humanities Statement of Intent 2016-2017',
    'message' => "Submission of letter of intent to the Public Humanities funding program at the UF Center for the Humanities and the Public Sphere:\n\nFORM_FIELDS",
);

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
);

$email_form = new Form( array(
    'id' => 'email-form',
    'action' => HOME_URL . '/index.php',
    'captcha' => '6Lf1UAcUAAAAADPggsA_poVLfN0CkqOlsymfGRsr',
    'fields' => $email_fields,
));



?>