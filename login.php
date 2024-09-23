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
    <title>Login Page</title>
    <!-- This script contains a "script or code" for the recaptcha -->
    <!-- The async allows us to run this script or code as soon as it's loaded without blocking other elements -->
    <script src="https://google.com/recaptcha/api.js" async defer></script>
    <!-- I use tailwindcss for my styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="index.css">

</head>

<body>
    <?php include('./components/navigation.php') ?>

    <div class="w-full h-screen flex justify-center items-center flex-col ">

        <form method="POST" action="./action/action_login.php" class="flex flex-col items-center border p-8 w-full md:w-1/2 lg:w-1/3 gap-y-4 shadow-lg rounded-md bg-black rounded-md bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-50 border border-gray-100">
            <h1 class="text-3xl font-black text-white">Login</h1>
            <!-- User Name Input -->
            <input
                type="text"
                name="user_name"
                placeholder="Enter user name"
                class="w-full border border-gray-300 rounded-md px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-[#35EAFF] focus:border-transparent bg-transparent"
                required />
            <!-- password Input -->

            <input
                type="password"
                name="password"
                placeholder="Enter password"
                class="w-full border border-gray-300 rounded-md px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-[#35EAFF] focus:border-transparent bg-transparent"
                required />

            <!-- I use htmlspecialChars to convert special characters to HTML entities -->
            <div class="g-recaptcha" data-sitekey="<?php echo htmlspecialchars($recaptchaSiteKey); ?>"></div>

            <button
                type="submit"
                name="btn_submit"
                class="w-full bg-[#35EAFF] text-white font-semibold px-4 py-2 rounded-md transition-all duration-300 ease-in-out text-xl">
                Login
            </button>


        </form>


    </div>

    <?php if (isset($_GET['status'])): ?>
        <script>
            const status = "<?php echo htmlspecialchars($_GET['status']); ?>";
            if (status === "success") {
                alert("Login successful!");
            } else if (status === "error") {
                alert("Username or password is incorrect.");
            } else if (status === "recaptcha_required") {
                alert("reCAPTCHA is required. Please check the box to verify you are human.");
            }
        </script>
    <?php endif; ?>
</body>

</html>