<?php 
class Form {
    public $id;
    public $fields;
    public $action;
    public $method;
    public $enctype;
    public $accept;
    public $captcha;
    public $errors;
    
    function __construct( $args = array() ){
        $defaults = array(
            'id' => 'form-1',
            'fields' => array(),
            'action' => '',
            'method' => 'post',
            'enctype' => 'application/x-www-form-urlencoded', // Use 'multipart/form-data' for forms including uploads
            'accept' => '', // Use for forms including uploads
            'captcha' => '',
        );
        extract( array_merge( $defaults, $args ) );
        
        $this->id = $id;
        $this->fields = $fields;
        $this->action = $action;
        $this->method = $method;
        $this->enctype = $enctype;
        $this->accept = $accept;
        $this->captcha = $captcha;
    }
    
    function display(){
        echo '<form id="' . $this->id . '" name="' . $this->id . '" method="' . $this->method . '" enctype="' . $this->enctype . '" action="' . $this->action . '">';
        echo '<div class="row"><div class="col-md-12">';
        
        if ( !empty($this->errors) ){
            foreach ( $this->errors as $error ){
                printf( '<div class="alert alert-danger" role="alert">%s</div>', $error );
            }
        }
        
        echo '<div class="form-fields">';
        
        foreach( $this->fields as $field ){
            $field->display();
        }
        
        if ( !empty($this->captcha) ) {
            echo '<div class="g-recaptcha" data-sitekey="' . $this->captcha . '"></div>';
        }
        echo '</div>';
        
        echo '<p><input type="submit" name="submit" id="submit" value="Submit"></p>';
        echo '</div></div>';
        echo '</form>';
    }
    
    /**
     * Determine whether the form is valid, if not set the error property
     * @return boolean Whether submission is valid
     */
    function validate(){
        $errors = array();
        foreach ( $this->fields as $field ){
            if ( !$field->validate() ){
                $errors[$field->id] = $field->error;
            }
        }
        
        // Only check captcha if there aren't already errors
        if ( empty($errors) ){
            $captcha = array(
                'url' => 'https://www.google.com/recaptcha/api/siteverify',
                'data' => array(
                    'secret' => '6Lf1UAcUAAAAAL4-r_Rt_wOn5qiPI9We-8H0FPQ6',
                    'response' => $_POST['g-recaptcha-response'],
                ),
            );
            
            if ( PROJECT_DEBUG ){
                //$captcha['url'] = 'test_api.php';
            }
            
            // Use a query string for the request
            $data = http_build_query( $captcha['data'], '', '&' );
            
            $curl = curl_init( $captcha['url'] );
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data );
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded') );
            curl_setopt($curl, CURLINFO_HEADER_OUT, false);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_FAILONERROR, true);
            $response = curl_exec($curl);
            
            // Check for API error
            if ( $response === false ){
                $errors['g-recaptcha'] = curl_error($curl);
            }
            else {
                // Verify captcha response
                $response_data = json_decode( $response, true );
                
                if ( ! $response_data['success'] ){
                    
                    $error_messages = array(
                        'missing-input-secret' => 'A CAPTCHA parameter is missing.',
                        'invalid-input-secret' => 'A CAPTCHA parameter is invalid.',
                        'missing-input-response' => 'Missing required field. Please check the box for "I\'m not a robot".',
                        'invalid-input-response' => 'Invalid response for the CAPTCHA field.',
                    );
                    
                    $errors['g-recaptcha'] = 'Error: ';
                    foreach ( $response_data['error-codes'] as $error_code ){
                        $errors['g-recaptcha'] .= ' ' . $error_messages[$error_code];
                    }
                }
            }
            curl_close($curl);
            
            if ( PROJECT_DEBUG ){
                error_log('response: '. $response);
                error_log('errors: '. print_r($errors, true));
            }
        }
        
        $this->errors = $errors;
        return ( empty($errors) );
    }
    
    function get_field_value( $field_id ){
        
        foreach ( $this->fields as $field ){
            if ( $field->id == $field_id ){
                return $field->value;
            }
        }
        return false;
    }
    
    function send_email( $args = array() ) {
		
        extract( $args );
        
		$headers = "From: {$from}" . "\r\n";
		$headers .= "Reply-To: {$from}" . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$headers .= 'X-Mailer: PHP/' . phpversion();
        
        $message = $this->get_email_message( $message );
        
        $sent = mail($to, $subject, $message, $headers);
            
        if ( PROJECT_DEBUG ){
            $sent = true;
            error_log('send_email() message: '. $message);
        }
        
		return $sent;
	}
    
    function get_email_message( $email_message ){
        
        $excluded = array('submit', 'g-recaptcha-response');
		
		// Sort and add all fields to the message
		$form_fields = '';
        
		foreach( $this->fields as $field ){
            $value = $field->value;
			$title = $field->title;
            $id = $field->id;
            
            $value = ( is_array($value) )? join(', ', $value) : $value;
            
            if( !in_array( $id, $excluded ) ){
				$form_fields .= sprintf('<tr valign="top"><td width="25%%"><strong>%s</strong></td><td>%s</td></tr>', $title, $value);
			}
		}
        $form_fields = sprintf('<br><br><table width="100%%" border="1" cellpadding="10" style="font-family:sans-serif;">%s</table>', $form_fields);
        
        // Replace placeholder variables
        $message = sprintf( '<html><body style="font-family:sans-serif;">%s</body></html>', $email_message );
        $message = str_replace( 'FORM_FIELDS', $form_fields, $message );
        
		return $message;
    }
    
    function validate_captcha(){
        
        
    }
}
?>