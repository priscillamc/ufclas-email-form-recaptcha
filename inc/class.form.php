<?php 
class Form {
    public $id;
    public $fields;
    public $action;
    public $method;
    public $enctype;
    public $accept;
    public $errors;
    
    function __construct( $args = array() ){
        $defaults = array(
            'id' => 'form-1',
            'fields' => array(),
            'action' => '',
            'method' => 'post',
            'enctype' => 'application/x-www-form-urlencoded', // Use 'multipart/form-data' for forms including uploads
            'accept' => '', // Use for forms including uploads
        );
        extract( array_merge( $defaults, $args ) );
        
        $this->id = $id;
        $this->fields = $fields;
        $this->action = $action;
        $this->method = $method;
        $this->enctype = $enctype;
        $this->accept = $accept;
    }
    
    /**
     * Display the form and fields
     * @since 1.0.0
     */
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
        echo '</div>';
        
        echo '<p><input type="submit" name="submit" id="submit" value="Submit"></p>';
        echo '</div></div>';
        echo '</form>';
    }
    
    /**
     * Determine whether the form is valid, if not set the error property
     * 
     * @return boolean Whether submission is valid
     * @since 1.0.0
     */
    function validate(){
        $errors = array();
        foreach ( $this->fields as $field ){
            if ( !$field->validate() ){
                $errors[$field->id] = $field->error;
            }
        }
        $this->errors = $errors;
        return ( empty($errors) );
    }
    
    /**
     * Get values from a specific form field
     * 
     * @param integer $field_id
     * @return string|boolean Field value
     * @since 1.0.0
     */
    function get_field_value( $field_id ){
        
        foreach ( $this->fields as $field ){
            if ( $field->id == $field_id ){
                return $field->value;
            }
        }
        return false;
    }
}
?>