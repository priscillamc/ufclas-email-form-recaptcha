<?php 
class Email_Message {
    public $to;
    public $from;
    public $subject;
    public $message;
    
    function __construct( $args = array() ){
        $defaults = array(
            'to' => '',
            'from' => '',
            'subject' => '',
            'message' => '',
            'excluded_fields' => array(),
            'sent' => false,
            'error' => '',
        );
        extract( array_merge( $defaults, $args ) );
        
        $this->to = $to;
        $this->from = $from;
        $this->subject = $subject;
        $this->message = $message;
        $this->excluded_fields = $excluded_fields;
    }
    
    /**
     * Formats the email message as html, adds form field values
     * 
     * @param array $fields
     * @since 1.1.0
     */
    function set_message( $fields = array() ){
        $message = $this->message;
        $message_fields = '';
        $email_file = FORM_PROJECT_PATH . '/content/email_message.php';
        
        // If no message, check the content file
        if ( empty( $this->message ) ){
            if ( ( $email_message = file_get_contents($email_file) ) !== false ){
                $message = $email_message;
            }
        }
        
        // Sort and add all fields to the message
        if( !empty($fields) ){
            foreach( $fields as $field ){
                $value = $field->value;
                $title = $field->title;
                $id = $field->id;

                $value = ( is_array($value) )? join(', ', $value) : $value;

                if( !in_array( $id, $this->excluded_fields ) ){
                    $message_fields .= sprintf('<tr valign="top"><td width="25%%"><strong>%s</strong></td><td>%s</td></tr>', $title, $value);
                }
            }
            $message_fields = sprintf('<br><br><table width="100%%" border="1" cellpadding="10" style="font-family:sans-serif;">%s</table>', $message_fields);
            
            // Replace the placeholder variables
            $message = str_replace( '<!--{FORM_FIELDS}-->', $message_fields, $message );
        }
        
		// Add html wrapper for message
        $this->message = sprintf( '<html><body style="font-family:sans-serif;">%s</body></html>', $message );
    }
    
    /**
     * Sends the email using optional form fields
     * 
     * @param Form $form
     * @since 1.1.0
     */
    function send_email( $form = null ) {
        if ( empty($this->to) || empty($this->from) ){
            $this->sent = false;
            return;
        }
        
        // Set email headers
		$headers = "From: {$this->from}" . "\r\n";
		$headers .= "Reply-To: {$this->from}" . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$headers .= 'X-Mailer: PHP/' . phpversion();
        
        if ( isset($form) ){
            $this->set_message( $form->fields );
        }
        
        // Log message or send email
        if( FORM_DEBUG ){
            $test_message = '<pre>Subject: ' . $this->subject . '<br>';
            $test_message .= 'To: ' . htmlspecialchars($this->to) . '<br>';
            $test_message .= htmlspecialchars($headers) . "</pre><br><br>";
            $test_message .= $this->message . "<br>";
            $test_file = 'test_message_' . date('Y-m-d-His') . '.html';
            $this->sent = file_put_contents( $test_file, $test_message );
            sleep(1); // make sure file name is unique
        }
        else {
            $this->sent = mail($this->to, $this->subject, $this->message, $headers);
        }
	}
}
?>