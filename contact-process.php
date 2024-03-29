<?php
session_start();

 define("WEBMASTER_EMAIL", 'info@imsolutions.mobi');

 define("WEBMASTER_EMAIL1", 'atul@imsolutions.mobi');

 /*define("WEBMASTER_EMAIL2", 'manikanta.tammina@gmail.com');*/


/*
define("WEBMASTER_EMAIL", 'ravi.k@imsolutions.mobi');
define("WEBMASTER_EMAIL1", 'ravi.k@imsolutions.mobi');*/


error_reporting(E_ALL & ~E_NOTICE);

function ValidateEmail($value) {
    $regex = '/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i';
    if ($value == '') {
        return false;
    } else {
        $string = preg_replace($regex, '', $value);
    }
    return empty($string) ? true : false;
}

function validate_mobile($phone) {
    return preg_match('/^[0-9]{10}+$/', $phone);
}

if ($_POST) {
   // echo 'working';
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $query = trim($_POST['message']);
    $subject = 'Enquiry from Mahindra ZEN';
    $error = '';

    // Check fullname
    if (empty($name)) {
        $error .= 'Please enter your Name.<br />';
        die('<p style="color:red;width:100%;">Please enter your Name</p>');
    }  

    if (empty($phone) || !validate_mobile($phone)) {
        $error .= 'Enter 10 digit mobile number.<br />';
        die('<p style="color:red;width:100%;">Enter 10 digit mobile number</p>');
    }

    if (empty($email)) {
        $error .= 'Please enter an e-mail address.<br />';
        die('<p style="color:red;width:100%;">Please enter an e-mail address</p>');
    }

    if (!ValidateEmail($email)) {
        $error .= 'Please enter a valid e-mail address.<br />';
        die('<p style="color:red;width:100%;">Please enter a valid e-mail address</p>');
    }

    if (empty($query)) {
        $error .= 'Please enter your message.<br />';
        die('<p style="color:red;width:100%;">Please enter your message</p>');
    }

    if (mb_strlen($query, 'utf-8') != strlen($query)) {
        $error .= 'Please enter English words only.<br>';
        die('<p style="color:red;width:100%;margin:0px;">Please enter English words only</p>');
    }

    if (strpos($query, 'http://') !== false || strpos($query, 'https://') !== false || strlen($query) > 200 || preg_match("/<[^<]+>/", $query)) {
        $error .= 'Invalid Message!.<br>';
        die('<p style="color:red;width:100%;margin:0px;">Invalid Message!</p>');
    }

    $email_name =  "Mahindra ZEN";
    $email_to = "noreply@mahindrazen.xyz";
    $headers = 'MIME-Version: 2.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: ' . $email_name . ' <' . $email_to . '>' . "\r\n";
    $message = '
    <img src = "http://mahindrazen.xyz/assets/images/logo.png" alt="sln" style = "width:100px; display:block; margin:0% auto">

    <table cellspacing="0" cellpadding="0" style="width:100%; border-bottom:1px solid #eee; font-size:12px; line-height:135%">

    
   
    <tr style="background-color:#f5f5f5">
        <th style="vertical-align:top; color:#222; text-align:left; padding:7px 9px 7px 9px; border-top:1px solid #eee">Name <span style="color:red">*</span></th>
        <td style="vertical-align:top; color:#333; width:60%; padding:7px 9px 7px 0; border-top:1px solid #eee">' . $name . '</td>
    </tr>
    <tr style="">
        <th style="vertical-align: top;color:#222; text-align:left; padding:7px 9px 7px 9px; border-top:1px solid #eee">Email <span style="color:red">*</span></th>
        <td style="vertical-align:top;color:#333;width:60%;padding:7px 9px 7px 0;border-top:1px solid #eee">' . $email . '</td>
    </tr>
    <tr style="background-color:#f5f5f5">
        <th style="vertical-align:top; color:#222; text-align:left; padding:7px 9px 7px 9px; border-top:1px solid #eee">Phone Number <span style="color:red">*</span></th>
        <td style="vertical-align:top; color:#333; width:60%; padding:7px 9px 7px 0; border-top:1px solid #eee">' . $phone . '</td>
    </tr>
    <tr>
        <th style="vertical-align:top; color:#222; text-align:left; padding:7px 9px 7px 9px; border-top:1px solid #eee">Message <span style="color:red">*</span></th>
        <td style="vertical-align:top; color:#333; width:60%; padding:7px 9px 7px 0; border-top:1px solid #eee">' . $query . '</td>
    </tr>
    </table>';


    $mail1 = mail(WEBMASTER_EMAIL, $subject, $message, $headers, '-freturn@mahindrazen.xyz');
    $mail1 = mail(WEBMASTER_EMAIL1, $subject, $message, $headers, '-freturn@mahindrazen.xyz');
    //$mail1 = mail(WEBMASTER_EMAIL2, $subject, $message, $headers, '-freturn@mahindrazen.xyz');
    

    if (true) {  

        date_default_timezone_set('Asia/Kolkata');

        $utilities_path = __DIR__ . DIRECTORY_SEPARATOR . "./../utilities";

        $google_helper = $utilities_path . "/google/helper.php";

        require_once($google_helper);

        $data = [$name,$phone, $email, $query, 'Mahindra ZEN Landing Page'];

        $sheet_id = "1XIB6_DAzwV7fyCvMxarnIkRoA41BaD6Ud16qQ84MV-w";

        if(saveDataToSheet($sheet_id,$data)){ 
            echo   'OK';
            die();
        }
        
    }
}
?>


          