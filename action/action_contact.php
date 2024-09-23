<?php

// Include configuration with secret keys
$config = include('../secrets.php');
$recaptchaSecretKey = $config['recaptcha_secret_key'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ito yung makikita sa client-side na merong check box at kukunin ang response or value ng reCaptcha

    // Sa pag interact ng user sa isang form (including recaptcha), meron itong response 
    // (or token) na generated ni recaptcha. Itong token na to ay maisesend as part ng form
    // na masesend sa server. 
    $recaptcha_response = $_POST['g-recaptcha-response'];

    if (empty($recaptcha_response)) {
        // Redirect back to the form with a message indicating reCAPTCHA is required
        header("Location: ../contact.php?status=recaptcha_required");
        exit();
    }

    // Verify reCAPTCHA with Google's API


    // Nag api request sa google recaptcha verification api using the link below.
    // The secret key must pass to query params and the response ito ay yung response na ginawa ng user
    // after submitting the form.

    // Here's how it works: 
    // Ang site-key ay makikita lamang sa client-side (web page). When user submit the form and the recaptcha widget is displayed, yung key nito or token it tells Googles reCaptcha api which site is making a request.

    // Ang secret-key naman ay ginagamit lamang sa server-side. It is used only to communicate sa google's reCaptcha servers to verify the user's response (token) if it is valid or not. This is the only secret key na that only your server can validate reCaptcha responses sa gamit mong site.
    $verify_response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $recaptchaSecretKey . '&response=' . $recaptcha_response);


    // Ito yung response ng api request natin or yung recaptcha's verification na naka json format
    // and it converts to php object or array.
    $response_data = json_decode($verify_response);

    // If ang response ay may status na 'success'

    if ($response_data->success) {
        // reCAPTCHA validation was successful
        $user_name = htmlspecialchars($_POST['user_name']);
        $message = htmlspecialchars($_POST['message']);

        // Assume message sending logic here (e.g., saving to database, sending email, etc.)

        // Redirect back to the form with a success message
        header("Location: ../contact.php?status=success");
        exit();
    } else {
        // reCAPTCHA validation failed, return to form with an error message
        header("Location: ../contact.php?status=error");
        exit();
    }
} else {
    // If not a POST request, redirect to the form
    header("Location: ../contact.php");
    exit();
}
