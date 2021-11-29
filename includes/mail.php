<?php
// ini_set('display_errors', 1);
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json; charset=UTF-8');

$results = [];
$visitor_name = '';
$visitor_email = '';
$visitor_comment = '';
$visitor_topic = '';


// Validate
if (isset($_POST['firstname'])&& $_POST['firstname'] !=''){
    $visitor_name = filter_var(htmlspecialchars($_POST['firstname']), FILTER_SANITIZE_STRING);
} else {echo "First name not valid";}

if (isset($_POST['lastname'])&& $_POST['lastname'] !=''){
    $visitor_name .= ' '.filter_var(htmlspecialchars($_POST['lastname']), FILTER_SANITIZE_STRING);
} else {echo "Last name not valid";}

if (isset($_POST['email'])&& $_POST['email'] !=''){
    $visitor_email = filter_var(htmlspecialchars($_POST['email']), FILTER_VALIDATE_EMAIL);
} else {echo "Email not valid";}

if (isset($_POST['comment'])){
    $visitor_comment = filter_var(htmlspecialchars($_POST['comment']), FILTER_SANITIZE_STRING);
} else {echo "Please enter valid text";}


// Validate Dropdown 
if (isset($_POST['topic']) && $_POST['topic'] !='') {
    $visitor_topic = filter_var(htmlspecialchars($_POST['topic']));
} else {echo "Topic not selected";}
  
$results['name'] = $visitor_name;
$results['email'] = $visitor_email;
$results['comment'] = $visitor_comment;
$results['topic'] = $visitor_topic;


// require_once('recaptchalib.php');
//     $privatekey = "your_private_key";
//     $resp = recaptcha_check_answer (
//         $privatekey,
//         $_SERVER["REMOTE_ADDR"],
//         $_POST["recaptcha_challenge_field"],
//         $_POST["recaptcha_response_field"]);

//   if (!$resp->is_valid) {
//     die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
//          "(reCAPTCHA said: " . $resp->error . ")");
//   }


// Email Setup
if ($visitor_topic == "project") {
    $email_recipient = 'woodjoh783@gmail.com';
}
else if ($visitor_topic == "feedback") {
    $email_recipient = 'woodjoh783@gmail.com';
}
else if ($visitor_topic == "other") {
    $email_recipient = 'woodjoh783@gmail.com';
}
else { $email_recipient = 'woodjoh783@gmail.com';}

$email_subject = sprintf('PHP Form %s', $visitor_topic);
$email_message = sprintf('Name: %s, Email: %s, Comment: %s', $visitor_name, $visitor_email, $visitor_comment);  
$email_headers = array( 
    'Reply-To' => $visitor_email,
    'From'=>$visitor_email 
);


// Send Email
$email_result = mail($email_recipient, $email_subject, $email_message, $email_headers);

if ($email_result) {
    $results['message'] = sprintf('Thank you for reaching out to us, %s. You will be contacted within 3 business days.', $visitor_name);
} else {
    $results['message'] = ('There seems to be an error in sending the email.');
} 

echo json_encode($results);