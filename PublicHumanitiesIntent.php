<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html><head><?php // Customize values
	$admin_email = 'humanities-center@ufl.edu'; 	// form will send submission to this address
	$admin_name = "Center for the Humanities and the Public Sphere";	// 'from' name in the emails
	$admin_email_subject = "Public Humanities 2014-15 Statement of Intent";
	$confirmation_url = 'PublicHumanitiesIntentConfirmation.html';
	$confirmation_email_subject = "Confirmation: 2014-2015 Public Humanities Letter of Intent";
	$resubmit = true;
	
	// Email messages, FORM_FIELDS and IP_ADDRESS will be replaced with submitted values.
	$admin_email_message = "Form Submission:\n FORM_FIELDS \nFrom: IP_ADDRESS";
	$confirmation_email_message = "Thank you for your submission of a letter of intent to the Public Humanities funding program at the UF Center for the Humanities and the Public Sphere. We will respond via the email addresses you provided no later than Friday 21 February 2014.
	\n FORM_FIELDS \n Any queries about this program may be sent to the Acting Center Director, Dr. Sean Adams, at spadams@ufl.edu. ";
	
	// Required fields and labels
	// Single choice fields, for text, textarea, select, radio buttons only
	$user_email_field = '01email';
	$required_single = array(
		'01applicant1' => 'Co-Applicant Name (UF)',
		'02applicant2' => 'Co-Applicant Name (Community)',
		'04description' => 'Project Description',
	);
	// Email fields
	$required_email = array(
		'01email' => 'Email (UF Applicant)'
	);
	// Multiple choice fields, for checkboxes and select with multiple options
	$required_multiple = array();
	
	// Include required functions
	include('PublicHumanitiesIntentFunctions.php');
?>

<title>Call for Proposals | Center for the Humanities and the Public Sphere | University of Florida</title><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="SHORTCUT ICON" href="favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta http-equiv="Content-language" content="en" /><!--<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />-->

<meta name="keywords" content="" />
<meta name="description" content="" />

<link media="screen, projection" type="text/css" href="css/styles.css" rel="stylesheet" />
<link media="print" type="text/css" href="css/print.css" rel="stylesheet" /><!--[if lt IE 7]>
  	<link media="screen, projection" type="text/css" href="css/ieStyles.css" rel="stylesheet"/>
    <script type="text/javascript" src="scripts/unitpngfix.js"></script>
    <script type="text/javascript" src="scripts/popUpMenu.js"></script>
	<![endif]-->


<script type="text/javascript" src="scripts/jquery-1.3.2.min.js"></script><!--
	<script type="text/javascript" src="scripts/swfobject.js"></script>
	<script type="text/javascript">
		swfobject.registerObject("homeSplash", "9.0.0", "expressInstall.swf");
	</script>
  --><!-- Copyright 2001, 2002, 2003 Macromedia, Inc. All rights reserved. --><!-- Copyright 2001, 2002, 2003 Macromedia, Inc. All rights reserved. --><!-- Copyright 2001, 2002, 2003 Macromedia, Inc. All rights reserved. -->
  <style type="text/css">
	#emailForm input, #emailForm textarea  {padding: 6px;}
	#emailForm textarea {width: 75%;}
  </style></head>


<body>
<a name="top" id="top"></a>
<div class="header">
  <div class="page">
    <div class="right">
      <p align="right"><a href="http://www.ufl.edu"><img src="images/uftag.png" class="right" style="margin-top: 23px;" border="0" /></a> </p>
      <form action="http://search.ufl.edu/search" method="get">
        <input name="site" value="humanities.ufl.edu" type="hidden" />
        <label for="searchbox">
          <input name="query" id="searchbox" size="20" value="Search" alt="Search" onfocus="select();" type="text" />
        </label>
        <label for="source">
          <select id="source" name="source"><option value="web" selected="selected">Humanities</option><option value="allweb">UF</option><option value="phonebook">UF Phonebook</option></select>
        </label>
        <input name="Submit" value="Go" type="submit" />
      </form>
    </div>
    <div class="left"> <a href="index.html"><img style="margin-top: 23px;" src="images/logo.png" border="0" /></a> </div>
    <div class="clear"> </div>
  </div>
</div>
<div class="navContainer">
  <div class="page">
    <ul id="ul_NavBar">
      
      <!--      	<li><a href="#">HOME</a></li>-->
      
      <li><a href="about.html">ABOUT</a>
        <ul>
          <li><a href="about.html">About the Center</a></li>
          <li><a href="news.html">News</a></li>
          <li><a href="programs.html">Programs</a></li>
          <li><a href="staff.html">Staff</a></li>
          <li><a href="Affiliated.html">Affiliated Organizations</a></li>
          <li><a href="board.html">Advisory Board</a></li>
          <li><a href="directorletter.html">Letter From the Director</a></li>
          <li><a href="archive.html">Archives</a></li>
        </ul>
      </li>
      <li><a href="calendar.html">CALENDAR</a></li>
      <li><a href="grants.html">GRANTS/RESOURCES</a>
        <ul>
          <li><a href="grant-writing.html">UF Grant Writing Services</a></li>
          <li><a href="http://www.humanities.ufl.edu/funding-faculty-external-internal-option.html">Faculty Funding Opportunities</a></li>
          <li><a href="http://www.humanities.ufl.edu/funding-faculty-residential.html">Postdoctoral Opportunities</a></li>
          <li><a href="http://www.humanities.ufl.edu/funding-graduate-students.html">Graduate Funding Opportunities</a></li>
          <li><a href="digitalhum.html">Digital Humanities</a></li>
          <li><a href="public-humanities.html">Public Humanities</a></li>
      	<li><a href="http://www.humanities.ufl.edu/bookscanstation.html">BookScan Station</a></li>
    </ul>
    </li>
      <li><a href="grants.html">WORKING GROUPS</a>
        <ul>
          <li><a href="http://cismac.humanities.ufl.edu/">Collective for the Interdisciplinary Study of Medicine and Culture</a></li>
          <li>&nbsp;</li>
          <li><a href="http://www.digitalhumanities.group.ufl.edu">Digital Humanities Working Group</a></li>
          <li><a href="https://sites.google.com/site/ufenvhum/">Environmental Humanities Initiative</a></li>
        </ul>
      </li>
      <li><a href="support.html">SUPPORT US</a></li>
      <li><a href="contact.html">CONTACT US</a>
        <ul>
          <li><a href="contact.html">Contact Us</a></li>
          <li><a href="links.html">Links</a></li>
          <li><a href="directions.html">Directions</a></li>
        </ul>
      </li>
      <li><a href="index.html">HOME</a> </li>
    </ul>
  </div>
  <!--end navContainer-->
  
  <div class="perimeter">
    <div class="perimeterpage">
      <div class="page">
        <div class="page">
          <h1>Call for Proposals 2016-2017</h1>
          <span class="Apple-style-span" style="color: rgb(34, 34, 34); background-color: rgb(186, 193, 169); font-size: medium;"></span>
          <h2><span style="font-family: Georgia,&quot;Times New Roman&quot;,Times,serif;"></span>Public Humanities — Statement of Intent — Deadline: 12 February 2016 (5:00pm EST)</h2>
          <p>In order to encourage and enhance collaborations between the University of
            Florida and off-campus individuals, groups, and institutions, the
            Center will
            offer grants up to $3,000 to support public programs rooted in one or
            more of
            the humanities disciplines. The Center intends to foster, support, and
            publicize humanities initiatives that engage the public in thoughtful
            and  informed dialogues outside of the UF campus between May 1, 2015 and May
            1, 2016. These programs will draw on the human expertise of both UF and
            community partners. To submit a statement of intent to this program, please fill out
            the required fields below, and click "submit" to receive a confirmation
            of your submission by email.</p>
          
		<?php display_error_message(); ?>
      
		<form id="emailForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input name="token" value="<?php echo $token; ?>" type="hidden" />
		  <p style="font-weight: bold;"><label for="01applicant1">University of Florida Co-Applicant Name(s) and Affiliation(s)</label></p>
		  <p><input name="01applicant1" size="80" maxlength="150" value="<?php display_value('01applicant1'); ?>" required="" type="text" /></p>
		  <p style="font-weight: bold;"><label for="01email">Email Address of Corresponding University of Florida Co-Applicant</label></p>
		  <p><input name="01email" size="30" maxlength="50" value="<?php display_value('01email'); ?>" required="" type="text" /></p>
          <p style="font-weight: bold;"><label for="02description">Biographical description of University of Florida Co-Applicant</label></p>
          <p><textarea name="02description" rows="5" cols="80" required="">&lt;?php display_value('02description'); ?&gt;</textarea></p>
          <?php display_honeypot_field(); ?>
		 
          <p style="font-weight: bold;"><label for="02applicant2">Community Co-Applicant Name(s) and Affiliation(s)</label></p>
		  <p><input name="02applicant2" size="80" maxlength="150" value="<?php display_value('02applicant2'); ?>" required="" type="text" /></p>
		  <p style="font-weight: bold;"><label for="02email">Email Address of Corresponding Community Co-Applicant</label></p>
		  <p><input name="02email" size="30" maxlength="50" value="<?php display_value('02email'); ?>" required="" type="text" /></p>
          <p style="font-weight: bold;"><label for="03description">Biographical description of Community Co-Applicant</label></p>
          <p><textarea name="03description" rows="5" cols="80" required="">&lt;?php display_value('03description'); ?&gt;</textarea></p>
          <?php display_honeypot_field(); ?>
		 
          <p style="font-weight: bold;"><label for="04description">Please provide a description of the aim of the
            project and budgetary needs in no more than 300 words.</label></p>
		  <p><textarea name="04description" rows="10" cols="80" required="">&lt;?php display_value('04description'); ?&gt;</textarea></p>
          <?php display_honeypot_field(); ?>
		  <p><span style="font-weight: bold;"><input name="submit" value="Submit" type="submit" /></span></p>
		  </form>
		  
          <p></p>
          <p>Any queries about this program may be sent to the Center Director, Prof. Bonnie Effros, at <a href="mailto:humanities-center@ufl.edu">humanities-center@ufl.edu</a>.</p>
          <p align="right"><a href="#top">&gt;&gt; top</a></p>
          <p align="right"><a href="../newsroom.html">&gt;&gt; back to newsroom</a></p>
        </div>
      </div>
    </div>
    <div class="divider"> </div>
    <div class="perimeterfoot">
      <div class="page">
        <div class="rightfoot"> <a href="http://www.ufl.edu"><img style="margin-top: 50px;" src="images/uftag.png" /></a> </div>
        <div class="leftfoot">
          <div class="half">
            <p>Center for the Humanities<br />
              and the Public Sphere<br />
              College of Liberal Arts and Sciences<br />
              tel 352.392.0796<br />
              fax 352.392.5378<br />
              <a href="mailto:humanities-center@ufl.edu">humanities-center@ufl.edu</a></p>
          </div>
          <div class="half">
            <p>200 Walker Hall<br />
              P.O. Box 118030<br />
              University of Florida<br />
              Gainesville, FL 32611<br />
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body></html>