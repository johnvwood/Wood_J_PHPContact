<?php
// ini_set('display_errors', 1);
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json; charset=UTF-8');

$results = [];
$visitor_name = '';
$visitor_email = '';
$visitor_message = '';
$visitor_topic = '';


// Validate
if (isset($_POST['firstname']) && $_POST['firstname'] !='') {
    $visitor_name = filter_var(htmlspecialchars($_POST['firstname']), FILTER_SANITIZE_STRING);
} else {echo "First name not valid";}

if (isset($_POST['lastname']) && $_POST['lastname'] !=''){
    $visitor_name .= ' '.filter_var(htmlspecialchars($_POST['lastname']), FILTER_SANITIZE_STRING);
} else {echo "Last name not valid";}

if (isset($_POST['email']) && $_POST['email'] !=''){
    $visitor_email = filter_var(htmlspecialchars($_POST['email']), FILTER_VALIDATE_EMAIL);
} else {echo "Email not valid";}

if (isset($_POST['message'])){
    $visitor_message = filter_var(htmlspecialchars($_POST['message']), FILTER_SANITIZE_STRING);
}


// Validate Dropdown 
if (isset($_POST['topic']) && $_POST['topic'] !='') {
    $visitor_topic = filter_var(htmlspecialchars($_POST['topic']), FILTER_SANITIZE_STRING);
} else {echo "Topic not selected";}
  
$results['name'] = $visitor_name;
$results['message'] = $visitor_message;


// Dropdown Categories, could go to different emails, kept same for testing
if ($visitor_topic == "project") {
    $email_recepient = 'woodjoh783@gmail.com';
}
else if ($visitor_topic == "feedback") {
    $email_recepient = 'woodjoh783@gmail.com';
}
else if ($visitor_topic == "other") {
    $email_recepient = 'woodjoh783@gmail.com';
}
else { $email_recepient = 'woodjoh783@gmail.com';}

// Email Setup
$email_subject = sprintF('PHP Form %s', $visitor_topic);
$email_message = sprintF('Name: %s, Email: %s, Message: %s', $visitor_name, $visitor_email, $visitor_message);  
$email_headers = array( 'From'=> $visitor_email );


// Send Email
$email_result = mail($email_recepient, $email_subject, $email_message, $email_headers);

if ($email_result) {
    $results['message'] = sprintf('Thank you for reaching out to us, %s. You will be contacted shortly.', $visitor_name);
} else {
    $results['message'] = sprintf('We are sorry but the email did not go through.');
} 

echo(json_encode($results));