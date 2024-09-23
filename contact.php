<?php
// I just use a variable name $config to get the returned data from secrets.php
$config = include('./secrets.php');

// I use this variable to get a specific key which is the site key.
$recaptchaSiteKey = $config['recaptcha_site_key'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Page</title>
    <!-- This script contains a "script or code" for the recaptcha -->
    <!-- The async allows us to run this script or code as soon as it's loaded without blocking other elements -->
    <!-- The defere is use just to make sure that this script will execute after the page loads -->
    <script src="https://google.com/recaptcha/api.js" async defer></script>
    <!-- I use tailwindcss for my styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <?php include('./components/navigation.php') ?>

    <div class="w-full h-screen  flex justify-center items-center flex-col">
        <!-- Contact Form -->
        <form method="POST" action="./action/action_contact.php" class="flex items-center flex-col border p-10 w-full sm:w-3/4 lg:w-1/2 gap-y-5 rounded-lg shadow-lg bg-black rounded-md bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-50 border border-gray-100">
            <h1 class="text-4xl font-black text-white mb-4">Contact Form</h1>

            <!-- User Name Input -->
            <input type="text" name="user_name" placeholder="User name" class="w-full border border-gray-300 rounded-md text-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#35EAFF] focus:border-transparent bg-transparent" required>

            <!-- Message Textarea -->
            <textarea name="message" placeholder="Your message..." rows="5" class="w-full border border-gray-300 rounded-md text-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#35EAFF] focus:border-transparent resize-none bg-transparent" required></textarea>

            <!-- I use htmlspecialChars to convert special characters to HTML entities -->

            <div class="g-recaptcha" data-sitekey="<?php echo htmlspecialchars($recaptchaSiteKey); ?>"></div>

            <!-- Submit Button -->
            <button type="submit" name="btn_contact" class="px-6 py-3 w-full sm:w-auto bg-[#35EAFF] text-white font-semibold text-lg rounded-md transition-colors duration-300 ">
                Send
            </button>
        </form>
    </div>

    <!-- Handle alert messages after form submission -->
    <?php if (isset($_GET['status'])): ?>
        <script>
            const status = "<?php echo htmlspecialchars($_GET['status']); ?>";
            if (status === "success") {
                alert("Message sent successfully!");
            } else if (status === "error") {
                alert("reCAPTCHA verification failed. Please try again.");
            } else if (status === "recaptcha_required") {
                alert("reCAPTCHA is required. Please check the box to verify you are human.");
            }
        </script>
    <?php endif; ?>
</body>

</html>