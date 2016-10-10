UF CLAS Custom Form-to-Email
==============================

Description
-----------

Sends form submission and confirmation messages then redirects to a confirmation page. Uses Google reCAPTCHA API to avoid spam submissions.

- Author: Priscilla Chapman (CLAS IT)
- Author URI: https://it.clas.ufl.edu/

Please contact CLAS IT for support.

Requirements
------------
- PHP 5.6+
- PHP cURL
- PHP mail
- Google reCAPTCHA API Keys - https://www.google.com/recaptcha/

Usage
------

Note: Contact CLAS IT before making edits to any of the PHP files.

### How to set the fields in the form

Open and edit `$email_form` in `inc/functions.php`. The fields types and arguments are in the `inc/class.field.php` file.

### How to Change the Text above the Form or the Confirmation Page

Open and edit the following files to change the HTML that appears on the pages: 

- Text_Field
- Textarea_Field
- Email_Field
- Heading_Field
- Checkbox_Field
- Radio_Field*
- Captcha_Field* 
- File_Field*

Note: Radio, checkbox, and file upload fields are not fully implemented.

### How to Change the Email Message Text

Open and edit the following file to change the body of the email message: 

- content/email_message.php

The comment `<!--{FORM_FIELDS}-->`displays the form submission data when the email is sent. Do not remove this comment for the admin email message.

### How to change the header or footer text

In the `inc` folder there are two files: header.php and footer.php. 

Note: Changes made to these pages will appear on _both_ the form index and confirmation pages.

Changelog
---------


To-Do List
----------
- Add Radio field
- Add Checkbox field
- Add File field 
