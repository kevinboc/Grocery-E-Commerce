

<?php
    session_start();
    $conn = mysqli_connect("localhost","root", "","cmpe131");
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }
    //if user is already logged in it redirects user to home page
    if(isSet($_SESSION['login'])){
        header('Location: index.php');
    }
    //$conn->close();
?>
<?php
    //form action
    $success=false;
    $passwordNoMatch=false;
    $usernameTaken=false;
    $missingField=false;
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST['fname']!=null &&
        $_POST['email']!=null&& 
        $_POST['lname']!=null&&
        (null!=$_POST['password'])&&
        null!=$_POST['retypepass'])
        {
            if($_POST['password']==$_POST['retypepass']){
                $conn = mysqli_connect("localhost","root", "","cmpe131");
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                    echo "no connection";
                }
                $fname=$_POST["fname"];
                $lname=$_POST['lname'];
                $email=$_POST['email'];
                $password=$_POST["password"];
                $phone=$_POST["phonenumber"];
                $sql = "SELECT * FROM accounts where email='$email'";
                $result = mysqli_query($conn, $sql);
                $num = mysqli_num_rows($result);
                if($num==0){
                    $sql= "INSERT INTO accounts (fname, lastName, email, password, phonenumber) VALUES ('$fname','$lname','$email','$password','$phone');";
                    $result = mysqli_query($conn,$sql);
                    if($result){
                        $_SESSION['login'] = $email;
                        $success=true;
                        header('Location: index.php');
                    }
                }
                else{
                    $usernameTaken=true;
                }
            }
            else
            {
                $passwordNoMatch=true;
            }

        }
        else{
            $missingField=true;
        }
    }
    $conn->close();
?>

<html>

    <?php
        if($usernameTaken){
            echo '<script>alert("You already have an account, please log in")</script>';
        }
        if($success){
            echo '<script>alert("Account created, please log in")</script>';
        }
        if($passwordNoMatch){
            echo '<script>alert("Passwords do not match")</script>';

        }
        if($missingField){
            echo '<script>alert("Missing Field")</script>';

        }

    ?>

    <header>
        <title>Sign Up</title>
        <link rel="stylesheet" href="../style/form.css">
        <link rel="stylesheet" href="../style/navbar.css">
    </header>

    <body>
      <nav class="navBar">
        <ul>
            <img class="logo" src="../assets/logo-transparent.png" alt="">
        </ul>
      </nav>
      
        <h1 class="headerOne">Create your HomeBuy account</h1>
        <form action="signup.php" method="post" class="formBox">
            <input type="text" name="fname" class="loginFill" placeholder="First Name"><br>
            <input type="text" name="lname" class="loginFill" placeholder="Last Name"><br>
            <input type="text" name="email" class="loginFill" placeholder="Email"><br>
            <input type="password" name="password" class="loginFill" placeholder="Password"><br>
            <input type="password" name="retypepass" class="loginFill" placeholder="Confirm Password"><br>
            <input type="text" name="phonenumber" class="loginFill" placeholder="Phone Number"><br>
            <button type="submit" class="submitButton">Create Account</button>
        </form>
    </body>

</html>
