<?php
session_start();

/* ---------------- DATABASE CONNECTION ---------------- */
$conn = mysqli_connect("localhost", "root", "", "loginDB");

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

/* ---------------- LOGOUT FUNCTION ---------------- */
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

/* ---------------- IF USER ALREADY LOGGED IN SHOW WELCOME PAGE ---------------- */
if (isset($_SESSION['login_user'])) {
    ?>
    <html>
    <body>
    <h1 align="center">Welcome</h1>
    <h2 align="center"><?php echo $_SESSION['login_user']; ?></h2>

    <center>
    <a href="login.php?logout=true">Logout</a>
    </center>

    </body>
    </html>
    <?php
    exit();
}

/* ---------------- LOGIN CHECK ---------------- */
if (isset($_POST['submit'])) {

    $uname = $_POST['uname'];
    $pword = $_POST['pword'];

    // SQL Query (original logic preserved)
    $sql = mysqli_query($conn,
        "SELECT * FROM userlogin WHERE username='$uname' OR password='$pword'"
    );

    // Default empty values
    $dbuname = "";
    $dbpword = "";

    if ($row = mysqli_fetch_assoc($sql)) {
        $dbuname = $row['username'];
        $dbpword = $row['password'];
    }

    // Validation logic
    if ($dbuname !== "" && $dbpword !== "") {

        if ($dbuname == $uname && $dbpword == $pword) {
            $_SESSION['login_user'] = $uname;
            header("Location: login.php");
            exit();
        }
        elseif ($dbuname == $uname && $dbpword != $pword) {
            $msg = "Wrong password";
        }
        elseif ($dbuname != $uname && $dbpword == $pword) {
            $msg = "Wrong username";
        }

    } else {
        $msg = "Wrong username and password";
    }
}
?>

<!-- ---------------- LOGIN FORM ---------------- -->
<html>
<head><title>Login</title></head>
<body>
<center>
<h2>Login Page</h2>

<form action="login.php" method="post">
    Username: <input type="text" name="uname" required><br><br>
    Password: <input type="password" name="pword" required><br><br>
    <input type="submit" name="submit" value="Submit">
</form>

<?php
if (isset($msg)) {
    echo "<br><b style='color:red;'>$msg</b>";
}
?>

</center>
</body>
</html>

