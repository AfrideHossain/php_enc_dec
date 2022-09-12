<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./styles/style.css" type="text/css" />
    <title>HA HA HAH :)</title>
</head>

<body>
    <section class="background">
        <form class="form-body" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" accept-charset="utf-8">
            <h2>Good Luck :)</h2>
            <input type="text" name="password" id="password" placeholder="Password" required />
            <textarea name="message" id="message" placeholder="Write your message" required></textarea>
            <textarea name="mirror" id="mirror" placeholder="Encrypted text will be shown here..." readonly></textarea>
            <input type="submit" name="encrypt" id="encrypt" value="Encrypt" />
            <p>We don't share your Information</p>
        </form>
        <!-- yo -->
        <script>
            const mirror = document.getElementById("mirror");
            //mirror.innerText = "Hello world";
        </script>
        <?php
        include "../config/dbcon.php";
        define("cipher_meth", "AES-256-CTR");
        $iv_len = openssl_cipher_iv_length(constant("cipher_meth"));
        define("iv", openssl_random_pseudo_bytes($iv_len));

        function input_tester($data)
        {
            $data = htmlspecialchars($data);
            return $data;
        }

        function enc($str, $passKey, $iv)
        {
            // $iv = bin2hex($iv);
            $enc_txt = openssl_encrypt($str, constant("cipher_meth"), $passKey, 0, $iv);
            return $enc_txt;
        }

        //enc("hgfdhgjdfg", "ghj");

        if (isset($_POST["encrypt"])) {
            $pass = mysqli_real_escape_string($conn, input_tester($_POST["password"]));
            $plain_txt = mysqli_real_escape_string($conn, input_tester($_POST["message"]));

            //echo $pass . "<br>" . $plain_txt . "<br>";
            //echo enc($plain_txt, $pass);
            try {
                $iv = constant("iv");
                $enc_value = enc($plain_txt, $pass, $iv);
                $hex_iv = bin2hex($iv);
                //echo "<script> mirror.innerText = '" . $enc_value . "'; </script>";
                $sql = "INSERT INTO enc_info (password, enc_txt, dec_txt, iv) VALUES ('$pass', '$enc_value', '$plain_txt', '$hex_iv')";
                // // echo $sql . "<br>";
                if (mysqli_query($conn, $sql)) {
                    echo "<script> mirror.innerText = '" . $enc_value . "'; </script>";
                }
            } catch (Exception $e) {
                echo $e;
            }
        }
        ?>
        <!-- yo -->
    </section>
</body>

</html>