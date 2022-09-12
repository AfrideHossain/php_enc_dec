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
        <form class="form-body" method="post" accept-charset="utf-8">
            <h2>Good Luck :)</h2>
            <input type="text" name="password" id="password" placeholder="Password" required />
            <textarea name="message" placeholder="Write your message" required></textarea>
            <textarea name="mirror" id="mirror" placeholder="Decrypted text will be shown here..." readonly></textarea>
            <input type="submit" name="decrypt" id="decrypt" value="Decrypt" />
            <p>We don't share your Information</p>
        </form>
        <!-- yo -->
        <script>
            const mirror = document.getElementById("mirror");
            //mirror.innerText = "Hello world";
        </script>

        <?php
        include "./config/dbcon.php";
        function input_tester($data)
        {
            $data = htmlspecialchars($data);
            return $data;
        }

        if (isset($_POST["decrypt"])) {
            $enc_text = mysqli_real_escape_string($conn, input_tester($_POST["message"]));
            $pass = mysqli_real_escape_string($conn, input_tester($_POST["password"]));

            $sql = "SELECT dec_txt, password FROM enc_info WHERE enc_txt = '$enc_text'";
            //echo $enc_text . "<br>" . $pass . "<br>" . $sql;
            
            try {
                $result = mysqli_query($conn, $sql);
                //print_r ($result);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    if ($row["password"] == $pass) {
                        echo "<script> mirror.innerText = '" . $row["dec_txt"] . "'; </script>";
                    } else {
                        echo "<script> mirror.innerText = 'Oops! Give me the correct password.'; </script>";
                    }
                    
                } else {
                    echo "<script> mirror.innerText = 'Something missing'; </script>";
                }
                
            } catch (Exception $e) {
                echo $e;
            }
        }

        ?>
    </section>
</body>

</html>