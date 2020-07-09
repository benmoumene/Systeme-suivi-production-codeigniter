
<!-- I found that the "request_id" column of tb_employee_request is not in any use if we replace   3 tables with tb_employee_master. Hence the this column can be removed from tb_employee_request.-->

<style type="text/css">
table.bottomBorder { border-collapse:collapse; }
table.bottomBorder td, table.bottomBorder th { border-bottom:1px dotted black;padding:1px;
font-size:13px;
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
}
table.bottomBorder tr, table.bottomBorder tr { border:1px dotted black;padding:1px; }
</style> 
  <?php
 	include "db_Class.php";
  	$obj = new db_class();
	$obj->MySQL(); 
  
  	//image
//define a maxim size for the uploaded images in Kb
define ("MAX_SIZE","100000");  
//This function reads the extension of the file. It is used to determine if the file is an image by checking the extension. 
function getExtension($str) {
$i = strrpos($str,".");
if (!$i) { return ""; }
$l = strlen($str) - $i;
$ext = substr($str,$i+1,$l);
return $ext;
}
//This variable is used as a flag. The value is initialized with 0 (meaning no error found) and it will be changed to 1 if an errro occures. If the error occures the file will not be uploaded.
$errors=0;


		$datex = new DateTime(null, new DateTimeZone('ASIA/Dhaka'));			
  		$datex->modify('-3600 seconds');
		$date=$datex->format('m-d-Y');
		$datex=$datex->format("Y-m-d H:i:s");

		
	$submit_request = 0;


//$fromemail='test@gmail.com';
//$fromname='VIYELLATEX HR service desk admin';


$fromemail='noreply@viyellatexgroup.com';
$fromname='VIYELLATEX HR service desk admin';

				 
			if($fromemail!=NULL)
			{
			
			$date = new DateTime(null, new DateTimeZone('ASIA/Dhaka'));
			$date->modify('-3600 seconds');
			$date=$date->format("m-d-Y");	

			
	$toemail = array('nipunsarker56@gmail.com');
		//$cc_mail_list = array('liza.amena@viyellatexgroup.com');
	$bcc_mail_list = array('nipun.sarker@interfabshirt.com');
	//

			
			include_once('class.phpmailer.php');
			//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
			$mail             = new PHPMailer();
			//$body             = $mail->getFile('contents.php');
			$body             = 'Test Body';
			$mail->IsSMTP(); // telling the class to use SMTP
			//$mail->Host       = "10.234.20.23"; // SMTP server
			$mail->Host       = "webmail.viyellatexgroup.com"; // SMTP server
			$mail->From       = "$fromemail";
			$mail->FromName   = "$fromname";
		$mail->Subject    = 'Request for Create new HRSP Account';
			$mail->AltBody    = ".";

            $path = 'http://10.234.15.250:81/pts/uploads/mail_attachment/hb_running_po.csv';

            $mail->AddAttachment($path);

			$mail->MsgHTML($body);
			
			
			
			$rowz = 0;
			foreach($toemail as $namex)
			{		
			$mail->AddAddress($toemail[$rowz], $namex);	
			$rowz++;
			}
			
			
				$rowz = 0;
				foreach($bcc_mail_list as $rowz=>$namez)
				{		
				  $mail->AddBCC($bcc_mail_list[$rowz], $namez);	
				  $rowz++;
				}

			
			$msg='A request has been successfully sent to concern persons Email. You will be notified soon.';
			
			$sendmail=1;
			
			}
			else
			{
				$msg='Mail Send is Failed. Please Try Again.' ;
				$sendmail=0;
			}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
jahid
jahid_iubat@yahoo.com
-->

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php // require("admin/editor.php"); ?>
<!--
<script language="javascript" type="text/javascript" src="form/niceforms.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="form/niceforms-default.css" />
[if IE 6]>
<link href="default_ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->
</head>
<body>

<div id="wrapper" class="container">
	<div id="page">
		<div id="content1"> <!--<a href="#" class="image-style"><img src="images/img02.jpg" width="600" height="250" alt="" /></a>-->
<!--        <?php //if($error==1) { ?>
        
        <h2 style="color:#F00">Oops ! Sorry.</h2>
        <?php //} else { ?>
        
			<h2>Thank You !</h2>  <?php// } ?>
-->            

            
            <br/>
<?php

if($sendmail=='1')
{
		
if(!$mail->Send()) {
	error_reporting(0);
	ini_set('display_errors', "Off");
echo "Mailer Error: " . $mail->ErrorInfo;
}
else 
{
echo '<h3>'.$msg.'</h3> </br>' ;	
 //echo "Message sent!";
}

}
?>
</div>
</div>
</div>
</body>
</html>
	