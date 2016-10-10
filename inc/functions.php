<?php 

// Project constants
define('FORM_PROJECT_NAME', 'Project Name' );
define('FORM_PROJECT_PATH', dirname( dirname(__FILE__) ) ); // No trailing slash
define('FORM_PROJECT_URL', get_project_url()  );
define('FORM_SITE_URL', '' );
define('FORM_CAPTCHA_SITEKEY', '' );
define('FORM_CAPTCHA_SECRET', '' );
define('FORM_EMAIL_ADMIN_NAME', 'Site Admin' );
define('FORM_EMAIL_ADMIN_EMAIL', 'admin@example.com' );
define('FORM_EMAIL_SUBJECT', 'Test Form' );
define('FORM_DEBUG', false ); // Disregard captcha, don't send email

include FORM_PROJECT_PATH . '/inc/class.form.php';
include FORM_PROJECT_PATH . '/inc/class.field.php';
include FORM_PROJECT_PATH . '/inc/class.email_message.php';

// Set defaults for the email message sent to site admins
$admin_email = new Email_Message( array(
    'to' => get_project_email(),
    'from' => '',
    'subject' => "Submission: " . FORM_EMAIL_SUBJECT,
    'excluded_fields' => array('submit', 'g-recaptcha-response'),
) );

// Set defaults for the email message sent to form user
$confirm_email = new Email_Message( array(
    'to' => '',
    'from' => get_project_email(),
    'subject' => "Confirmation: " . FORM_EMAIL_SUBJECT,
    'excluded_fields' => array('submit', 'g-recaptcha-response'),
) );

// Set form fields
$email_fields = array(
    new Text_Field( array(
        'title' => 'Text Field',
        'id' => 'text-field-1',
        'default' => '',
        'required' => false,
    )),
    new Email_Field( array(
        'title' => 'Email Field',
        'id' => 'email-field-1',
        'default' => '',
        'required' => true,
        'send_email' => true,
    )),
    new Textarea_Field( array(
        'title' => 'Textarea Field',
        'id' => 'textarea-field-1',
        'required' => false,
    )),
    new Heading_Field( array(
        'title' => 'Heading Field',
    )),
    /*
    new Checkbox_Field( array(
        'title' => 'Checkbox Field',
        'id' => 'checkbox-field',
        'required' => false,
        'items' => array(
            'checkbox-1' => 'Checkbox One',
            'checkbox-2' => 'Checkbox Two',
            'checkbox-3' => 'Checkbox Three',
        ),
    )),
    new Radio_Field( array(
        'title' => 'Radio Field',
        'id' => 'radio-field',
        'required' => false,
        'items' => array(
            'yes' => 'Yes',
            'no' => 'No',
        ),
    )),
    new File_Field( array(
        'title' => 'File Upload Field',
        'id' => 'file-field',
        'required' => false,
        'multiple' => false,
        'upload_path' => FORM_PROJECT_PATH . '/uploads',
        'accept' => '',
    )),
    */
    new Captcha_Field( array(
        'title' => 'Verification',
        'id' => 'g-recaptcha-response',
        'url' => 'https://www.google.com/recaptcha/api/siteverify',
        'sitekey' => FORM_CAPTCHA_SITEKEY,
        'secret' => FORM_CAPTCHA_SECRET,
        'required' => false,
    )),
);

$email_form = new Form( array(
    'id' => 'email-form',
    'action' => FORM_PROJECT_URL . '/',
    'fields' => $email_fields,
));

/**
 * Helper function to get the url of the project root url
 * @since 1.1.1
 * @return string Project root folder
 */
function get_project_url(){
    $url = ( $_SERVER['SERVER_PORT'] == 80 )? 'http://' : 'https://';
    $url .= $_SERVER['HTTP_HOST'] . '/';
    $url .= basename(dirname($_SERVER['PHP_SELF']));
    return $url;
}

/**
 * Helper function to get the admin email
 * @since 1.1.1
 * @return string Project admin email
 */
function get_project_email(){
    $email = '';
    if ( (filter_var( FORM_EMAIL_ADMIN_EMAIL, FILTER_VALIDATE_EMAIL ) !== false ) ){
        $email = sprintf('%s <%s>', FORM_EMAIL_ADMIN_NAME, FORM_EMAIL_ADMIN_EMAIL);
    }
    
    return $email;
}

?>