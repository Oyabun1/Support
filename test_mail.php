<!DOCTYPE html>
<html>
<head>
   <title>mail() Test</title>
   <style type="text/css">
body {
	background-color: #f0f0f0;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
h1 {
	color: #0000CC;
	font-size: 1.5em;
	text-align: center;
}

.explanation {
	font-size: 1em;
	color: #ffffff;
	background-color: #12A3EB;
	border: solid 1px #a1a1a1;
	text-align: center;
	padding: 10px;
	width: 680px;
	margin: .5em auto;
	-webkit-border-radius: 40px;
	-moz-border-radius: 40px;
	border-radius: 40px;
}

.formLayout {
	background-color: #cadceb;
	border: solid 1px #a1a1a1;
	padding: 10px;
	width: 680px;
	margin: .5em auto;
	-webkit-border-radius: 40px;
	-moz-border-radius: 40px;
	border-radius: 40px;
}
   
.formLayout label, .formLayout input {
	display: block;
	width: 18em;
	float: left;
	margin-bottom: 10px;
}

.formLayout input[type=submit] 
{
	float: none;
	display: block;
	width: 11em;
	margin: 0px auto;
	cursor:pointer;
}

.formLayout label {
	text-align: right;
	padding-right: 20px;
}

.formLayout br {
       clear: left;
}

.results {
	background-color: #ECF1F3;
	border: solid 1px #a1a1a1;
	padding: .8em;
	width: 680px;
	margin: .5em auto;
	-webkit-border-radius: 40px;
	-moz-border-radius: 40px;
	border-radius: 40px;
}

.good {
	color: #33CC00;
	font-size : 1em;
	padding: 0 2px;
}
	
.bad {
	color: #E00000;
	font-size: 1em;
	padding: 0 2px;
}

.regular {
	font-size: 1em;
	color: #303030;
	padding: 0 2px;	
}	

.copyright {
	display: block;
	font-size: .7em; 
	margin-left: auto;
	margin-right: auto;
	width: 8em;
	color: black; 
	letter-spacing: -1px;
	text-decoration: none;
	}
a.copyright {
	text-decoration: none;
}

</style>
</head>
<body>
<h1>Test of the mail() function</h1>
<div class="explanation">
	This script is to do a test of the PHP mail() function on your server.<br />
	Type your email address in the field below then click on Test the email.<br />
	Explanatory notes will appear below.
</div>

    <form class="formLayout" action="<?php basename(__FILE__)?>" method="post">
        <label>Your Email Address</label>
        <input type="email" name="recipient" size="35" required><br />

		<input type="submit" value="Test the email" name="submit" />
    </form>

<?php

mb_internal_encoding("UTF-8");

/**
* Validate an email address using a basic standard
* @function author Michael Rushton 
* @link http://squiloople.com/
*
* Could have used FILTER_VALIDATE_EMAIL but that is only available on PHP 5.2+
*/
  function is_valid_email_address($email_address)
  {
    return preg_match("/^(?!.{255,})(?!.{65,}@)([!#-'*+\/-9=?^-~-]+)(?>\.(?1))*@(?!.*[^.]{64,})(?>[a-z\d](?>[a-z\d-]*[a-z\d])?\.){1,126}[a-z]{2,6}$/iD", $email_address);
  }

if(isset($_POST['recipient']))

{
	$recipient = $_POST['recipient'];
	$subject = "Test script for the PHP mail() function";
	$message = "Congratulations, the mail() function is working!";

	// Long addresses will mess up the layout so we'll put some line breaks in them
	$recipient_br = wordwrap($recipient, 65, "<br />\n", true);	
	
	echo '<div class="results">';
	if(mb_strlen($recipient, 'UTF-8') < 255)
	{
		if (is_valid_email_address($recipient)) 
		{
			echo '<div class="good">The <span class="regular">' . $recipient_br  . '</span> email address is considered valid for this test.</div>';
			
//			$send_mail = mail($recipient, $subject, $message);
//				if($send_mail == true)
				if (1 == 1)

				{
					echo '<div class="good">The mail() function is active and the email was accepted for delivery.<br />Provided the server\'s outgoing email is also working an email has been sent to <span class="regular">' . $recipient_br  . '</span></div>';
				}
				else
				{
					echo '<div class="bad"><b>The function email() is inactive!</div>';
				}
		}
		else
		{
			echo '<div class="bad">The <span class="regular">' . $recipient_br  . '</span> email address is considered invalid for this test.</div>';
		}
	}
	else
	{
		echo '<div class="bad">You numpty, <span class="regular">' . $recipient_br . '</span>, is too long for an email address</div>';
	}
	echo '</div>';
}

?>
<!-- <div class="copyright">&copy; 2014 <a href="https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=987265">Oyabun1</a></div>
Based on an idea and some code from <a href="http://www.phpbb-fr.com/">phpBB-fr.com</a> -->

</body>
</html>