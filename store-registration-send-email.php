<?php
if(isset($_POST['password-reset-token']) && $_POST['email'])
{
include "register.php";
$result = mysqli_query($conn,"SELECT * FROM users WHERE email='" . $_POST['email'] . "'")or die("error");
$row= mysqli_num_rows($result);
if($row < 1)
{
$token = md5($_POST['email']).rand(10,9999);
mysqli_query($conn, "INSERT INTO users(name, email, email_verification_link ,password) VALUES('" . $_POST['name'] . "', '" . $_POST['email'] . "', '" . $token . "', '" . md5($_POST['password']) . "')");
$link = "<a href='localhost/email-verification/verify-email.php?key=".$_POST['email']."&token=".$token."'>Click and Verify Email</a>";
require_once('phpmail/PHPMailerAutoload.php');
$mail = new PHPMailer();
$mail->CharSet =  "utf-8";
$mail->IsSMTP();
// enable SMTP authentication
$mail->SMTPAuth = true;                  
// GMAIL username
$mail->Username = "swathekajebaraj127@gmail.com";
// GMAIL password
$mail->Password = "Jesusisalive@12";
$mail->SMTPSecure = "ssl";  
// sets GMAIL as the SMTP server
$mail->Host = "smtp.gmail.com";
// set the SMTP port for the GMAIL server
$mail->Port = "465";
$mail->From='swathekajebaraj127@gmail.com';
$mail->FromName='swatheka';
$mail->AddAddress('reciever_email_id', 'reciever_name');
$mail->Subject  =  'Reset Password';
$mail->IsHTML(true);
$mail->Body    = 'Click On This Link to Verify Email '.$link.'';
if($mail->Send())
{
echo "Check Your Email box and Click on the email verification link.";
}
else
{
echo "Mail Error - >".$mail->ErrorInfo;
}
}
else
{
echo "You have already registered with us. Check Your email box and verify email.";
}
}
?>