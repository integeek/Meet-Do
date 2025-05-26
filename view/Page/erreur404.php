<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" type="text/css" href="../component/Footer/Footer.css">
    <link rel="stylesheet" type="text/css" href="../component/Navbar/Navbar.css">
    <style>
    </style>
</head>

<body>
    <header>
        <div id="navbar-container" class="navbar-container"></div>
        <script src="../component/Navbar/Navbar.js"></script>
        <script>
    (async () => {
        document.getElementById('navbar-container').innerHTML = await Navbar("..");
        if (!window.navActionLoaded) {
            const script = document.createElement('script');
            script.src = "../component/Navbar/navAction.js";
            script.onload = () => {
                window.navActionLoaded = true;
                window.initializeNavbar();
            };
            document.body.appendChild(script);
        } else {
            window.initializeNavbar();
        }
    })();
</script>
    </header>

    <body>
        <p style="font-size: 180px; color: red;text-align: center;vertical-align: top; margin: 0;">404</p>
        <p style="font-size: 50px; text-align: center;vertical-align: top;">cette page n'existe pas</p>



        <footer id="footer-container" class="footer-container">
            <script src="../component/Footer/Footer.js"></script>
            <script>
                document.getElementById('footer-container').innerHTML = Footer("..");
            </script>
        </footer>

        </dive>

    </body>

</html>