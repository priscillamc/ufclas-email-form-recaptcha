<?php 
class Field {
    public $title;
    public $type;
    public $id;
    public $default;
    public $required;
    public $error;
    public $value;
    
    function __construct( $args = array() ){
        $defaults = array(
            'title' => 'Text Field',
            'type' => 'text',
            'id' => 'text-field',
            'default' => '',
            'required' => false,
            'items' => array(),
            'error' => array(),
        );
        extract( array_merge( $defaults, $args ) );
        
        $this->title = $title;
        $this->type = $type;
        $this->id = $id;
        $this->default = $default;
        $this->required = $required;
        $this->value = ( !empty($this->default) )? $this->default : null;
    }
    
    /**
     * Display the field
     * 
     * @since 1.0.0
     */
    function display(){
        echo '<p class="form-group' . $this->get_group_classes() . '" id="form-group-' . $this->id . '">';
        echo '<label for="' . $this->id . '" class="control-label">' . $this->title . '</label>';
        echo '<input type="' . $this->type . '" name="' . $this->id . '" id="' . $this->id . '" value="' . $this->value . '" class="form-control"' . $this->get_control_attrs() . '>';
        echo $this->get_help_block();
        echo '</p>';
    }
    
    /**
     * Determine form-group classes for required and errors in fields
     * 
     * @return string Class names
     * @since 1.0.0
     */
    function get_group_classes( $defaults = array() ){
        $classes = $defaults;
        
        if ( $this->required ){
            $classes[] = 'is-required';
        }
        if ( !empty($this->error) ){
            $classes[] = 'has-error';    
        }
        return ' ' . join( ' ', $classes );
    }
    
    /**
     * Determine form-control attributes for required and errors in fields
     * 
     * @return string Attribute text
     * @since 1.0.0
     */
    function get_control_attrs( $defaults = array() ){
        $attrs = $defaults;
        
        if ( $this->required ){
            $attrs[] = 'required';
        }
        if ( !empty($this->error) ){
            $attrs[] = sprintf('aria-describedBy="help-block-%s"', $this->id);    
        }
        return ' ' . join( ' ', $attrs );
    }
    
    /**
     * Display help or error text below fields
     * 
     * @return string Field description or error
     * @since 1.0.0
     */
    function get_help_block( $default_text = '' ){
        $text = $default_text;

        if ( !empty($this->error) ){
            $text .= sprintf( '<span class="help-block" id="help-block-%s">%s</span>', $this->id, $this->error );  
        }
        return $text;
    }
    
    /**
     * Sets the field value from POST, only checks for a submitted value
     * 
     * @return boolean Whether field value is valid
     * @since 1.0.0
     */
    function validate(){
        $this->error = array();
        $this->value = ( isset($_POST[$this->id]) )? trim($_POST[$this->id]) : $this->value;
        
        // Check for required fields
        if ( $this->required && (strlen($this->value) == 0) ){
            $this->error = 'Missing required value.';
            return false;
        }
        else {
            return true;
        }
    }
}

class Text_Field extends Field {
    
    /**
     * Sets the sanitized field value from post, checks if valid
     * 
     * @return boolean Whether field value is valid
     * @since 1.0.0
     */
    function validate(){
        $valid = parent::validate();
        
        // Sanitize value. Strip tags from string
        $this->value = filter_var( $this->value, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES );
        
        return $valid;
    }
}

class Textarea_Field extends Field {
    
    function __construct( $args = array() ){
        parent::__construct( array_merge( array('type' => 'textarea'), $args ) );
    }
    
    /**
     * Display the field
     * 
     * @since 1.0.0
     */
    function display(){
        echo '<p class="form-group' . $this->get_group_classes() . '">';
        echo '<label for="' . $this->id . '" class="control-label">' . $this->title . '</label>';
        echo '<textarea name="' . $this->id . '" id="' . $this->id . '" class="form-control" rows="5"' . $this->get_control_attrs() . '>' . $this->value . '</textarea>';
        echo $this->get_help_block();
        echo '</p>';
    }
    
    /**
     * Sets the sanitized field value from post, checks if valid
     * 
     * @return boolean Whether field value is valid
     * @since 1.0.0
     */
    function validate(){
        $valid = parent::validate();
        
        if(!$valid){
           return false; 
        }
        else {
            // Sanitize value. Strip tags from string
            $this->value = strip_tags($this->value);
            $this->value = stripslashes($this->value);
            $this->value = htmlspecialchars($this->value);
            $this->value = nl2br($this->value);
            return true;
        }
    }
}

class Email_Field extends Field {
    
    function __construct( $args = array() ){
        parent::__construct( array_merge( array('type' => 'email'), $args ) );
    }
    
    /**
     * Sets the sanitized field value from post, checks if valid
     * 
     * @return boolean Whether field value is valid
     * @since 1.0.0
     */
    function validate(){
        $valid = parent::validate();
        
        // Sanitize value. Strip tags from string
        $this->value = filter_var( $this->value, FILTER_SANITIZE_EMAIL );
        
        if ( !$valid ){
            return false;
        }
        else {
            if ( filter_var( $this->value, FILTER_VALIDATE_EMAIL) === false ) {
                $this->error = 'Email address is not valid.';
                return false;
            }
            else {
                return true;
            }
        }
    }
}

class Heading_Field extends Field {
    public $tag;
    public $id;
    
    function __construct( $args = array() ){
        $defaults = array(
            'title' => 'Heading',
            'tag' => 'h3',
            'id' => '',
        );
        
        $args = array_merge( $defaults, $args );
        
        $this->title = $args['title'];
        $this->tag = $args['tag'];
        $this->id = $args['id'];
    }
    
    /**
     * Display the field
     * 
     * @since 1.0.0
     */
    function display(){
        $html = sprintf( '<%s>%s</%s>', $this->tag, $this->title, $this->tag );
        
        if ( !empty( $this->id ) ){
            $html = sprintf( '<div id="%s">%s</div>', $this->id, $html );
        }
        
        echo $html;
    }
}

class Checkbox_Field extends Field {
    public $items;
    
    function __construct( $args = array() ){    
        $defaults = array(
            'title' => 'Checkbox Field',
            'type' => 'checkbox',
            'id' => 'checkbox-field',
            'default' => '',
            'required' => false,
            'items' => array(),
        );
        
        $fieldset_args = array_merge( $defaults, $args );
        $this->items = $fieldset_args['items'];
        parent::__construct( array_merge( $fieldset_args, $args ) );
    }
    
    /**
     * Display the field
     * 
     * @since 1.0.0
     */
    function display(){
        $required_txt = ($this->required)? ' required':'';
		echo '<fieldset class="form-group" id="form-group-' . $this->id . '">';
        echo '<legend>' . $this->title . '</legend>';
        foreach($this->items as $value => $label) {
          	$selected = $this->get_value( true );
			if($this->type == 'checkbox'){
				$checked = '';
				$item_name = $this->id . '[]';
				if(!empty($selected)){
					$checked = (in_array($value, $selected))? ' checked="checked"':'';
				}
			}
			else {
				$checked = ($value == $selected)? ' checked="checked"':'';
				$item_name = $this->id;
			}
            $item_id = $this->id . '-' . $value;
            echo '<div class="' . $this->type . '"><label>';
            echo '<input name="' . $item_name . '" type="' . $this->type . '" id="' . $item_id . '" value="' . $value . '"' . $checked . '>';
            echo $label . '</label></div>';
        }
        echo '</fieldset>';
    }
}

class Radio_Field extends Checkbox_Field {
    
    function __construct( $args = array() ){
        parent::__construct( array_merge( array('type' => 'radio'), $args ) );
    }
}

class File_Field extends Field {
    public $multiple;
    public $upload_path;
    
    function __construct( $args = array() ){
        
        $defaults = array(
            'title' => 'File Upload',
            'type' => 'file',
            'id' => 'file-upload',
            'default' => '',
            'required' => false,
            'multiple' => false,
            'upload_path' => '',
            'accept' => '',
        );
        
        $file_args = array_merge( $defaults, $args );
        $this->multiple = $file_args['multiple'];
        $this->upload_path = $file_args['upload_path'] . '/' . $file_args['id'] . '.csv';
        $this->accept = $file_args['accept'];
        parent::__construct( $file_args );
    }
    
    /**
     * Display the field
     * 
     * @since 1.0.0
     */
    function display(){
        $required_txt = ($this->required)? ' required':'';
        $multiple_txt = ($this->multiple)? ' multiple':'';
        $accept_txt = (!empty($this->accept))? ' accept="' . $this->accept . '"':'';
        
        echo '<p class="form-group" id="form-group-' . $this->id . '">';
        printf('<label for="%s">%s</label>', $this->id, $this->title);
        printf('<input type="%s" name="%s" id="%s" class="form-control" %s%s%s />', $this->type, $this->id, $this->id, $accept_txt, $required_txt, $multiple_txt);
        echo '</p>';
    }
    
    /**
     * Uploads selected file to the path
     * 
     * @since 1.0.0
     */
    function upload(){
        if ( $_FILES[$this->id]['error'] == UPLOAD_ERR_OK ){
            
            $name = basename( $_FILES[$this->id]['name'] );
            if ( move_uploaded_file( $_FILES[$this->id]['tmp_name'], $this->upload_path ) ){
                return 'Success: File uploaded.';
            }
            else {
                return 'Error: File not uploaded.';
            }
        }
    }
}

class Captcha_Field extends Field {
    public $url;
    public $sitekey;
    public $secret;
    
    function __construct( $args = array() ){
        
        $defaults = array(
            'title' => 'File Upload',
            'type' => '',
            'id' => '',
            'default' => false,
            'required' => true,
            'url' => '',
            'sitekey' => '',
            'secret' => '',
        );
        
        $field_args = array_merge( $defaults, $args );
        $this->url = $field_args['url'];
        $this->sitekey = $field_args['sitekey'];
        $this->secret = $field_args['secret'];
        parent::__construct( $field_args );
    }
    
    /**
     * Display the field
     * 
     * @since 1.1.0
     */
    function display(){
        echo '<div class="form-group' . $this->get_group_classes() . '" id="form-group-' . $this->id . '">';
        echo '<p class="control-label">' . $this->title . '</p>';
        echo '<div class="g-recaptcha" data-sitekey="' . $this->sitekey . '"></div>';
        echo $this->get_help_block();
        echo '</div>';
    }
    
    /**
     * Sets the sanitized field value from post, checks if valid
     * 
     * @return boolean Whether field value is valid
     * @since 1.1.0
     */
    function validate(){
        $valid = parent::validate();
        
        if(!$valid){
           return false; 
        }
        
        // Use a query string for the request
        $data = array(
            'secret' => $this->secret,
            'response' => $this->value,
        );
        $data = http_build_query( $data, '', '&' );

        // Post to the Google reCAPTCHA API
        $curl = curl_init( $this->url );
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data );
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded') );
        curl_setopt($curl, CURLINFO_HEADER_OUT, false);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        $response = curl_exec($curl);
        $curl_error = curl_error($curl);
        curl_close($curl);

        // Check for curl response errors
        if ( $response !== false && !empty($response) ){
            
            $this->error = ''; // Reset the error message
            
            $response_data = json_decode( $response, true );
            $valid = ( $response_data['success'] ); // Check the API response
            
            if ( !$valid ){
                // Error messages for API response codes
                $error_messages = array(
                    'missing-input-secret' => 'A verification parameter is missing. Contact your site administrator.',
                    'invalid-input-secret' => 'A verification parameter is invalid. Contact your site administrator.',
                    'missing-input-response' => 'Missing required verification.',
                    'invalid-input-response' => 'Invalid verification response.',
                );
                if ( isset($response_data['error-codes']) ){
                    foreach ( $response_data['error-codes'] as $error_code ){
                        $this->error .= 'Error: ' . $error_messages[$error_code];
                    }   
                }
            }
        }
        else{
            $this->error = (empty($curl_error))? 'Problem verifying form submission.' : $curl_error;
            $this->error = 'Error: ' . $this->error;
            $valid = false;
        }
        
        return $valid;
    }
}

?>