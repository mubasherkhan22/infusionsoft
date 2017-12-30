<?php
session_start();

require_once 'vendor/autoload.php';

$infusionsoft = new Infusionsoft\Infusionsoft(array(
    'clientId'     => 'XXXXXXXXXXXXXXXXXXXXXX',
    'clientSecret' => 'XXXXXXXXX',
    'redirectUri'  => 'http://localhost/infusion21/test.php',
));

// If the serialized token is available in the session storage, we tell the SDK
// to use that token for subsequent requests.
if (isset($_SESSION['token'])) {
	$infusionsoft->setToken(unserialize($_SESSION['token']));
}

// If we are returning from Infusionsoft we need to exchange the code for an
// access token.
if (isset($_GET['code']) and !$infusionsoft->getToken()) {
	$_SESSION['token'] = serialize($infusionsoft->requestAccessToken($_GET['code']));
}

if ($infusionsoft->getToken()) {
	// Save the serialized token to the current session for subsequent requests
	$_SESSION['token'] = serialize($infusionsoft->getToken());

	// MAKE INFUSIONSOFT REQUEST
} else {
	echo '<a href="' . $infusionsoft->getAuthorizationUrl() . '">Click here to authorize</a>';
}

echo ">>>>>>>>>token<<<<<<<<<<<<<<<<<<<";
print_r($token);	
echo ">>>>>>>>>token<<<<<<<<<<<<<<<<<<<";

echo "<pre>";
var_dump($infusionsoft);

?>
<form method="post" action="">
Name: <input type="text" name="name">
Family Name <input type="text" name="family">
Email <input type="email" name="email">
Phone <input type="number" name="phone">
<a href=""><input type="submit" name="submit"></a>
<?php


if(isset($_POST['submit']))
{
	
	
    $email1         = new \stdClass;
    $email1->field  = 'EMAIL1';
    $email1->email  = $_POST['email'];
    $phone1         = new \stdClass;
    $phone1->field  = 'PHONE1';
    $phone1->number = $_POST['phone'];
    $contact        = ['given_name'      => $_POST['name'],
                       'family_name'     => $_POST['family'],
                       'email_addresses' => [$email1],
                       'phone_numbers'   => [$phone1]
    ];


    try {

    	$cont = $infusionsoft->contacts()->create($contact);
    	echo "done";
    } catch (Exception $e) {
    	var_dump($e);
    }

} 