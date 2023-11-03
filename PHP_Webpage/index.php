<?php
//Ensure user is not logged in
session_start();

if (isset($_SESSION["name"])) {
    echo 'Direct access not permitted. Please log out properly, <a href="home.php">back to home</a>.';
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sign In</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Luckiest Guy' rel='stylesheet'>
    <link rel="stylesheet" href="../CSS/global.css">
    <link rel="stylesheet" href="../CSS/index.css">
</head>

<body>
    <div class="flex-container">
        <div class="bookLeft">
            <h1>DUNOT</h1>
            <p>Where Imaginations Come to Life</p>
        </div>

        <div class="bookRight">
            <div class="rightContent">
                <h2>Welcome Back</h2>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="signinForm"
                    onsubmit="return checkAll()">
                    <div class="radio-button-group">
                        <input type="radio" id="userRadio" name="userType" value="User" checked>
                        <label for="userRadio" id="userLabel" class="radioLabel">User</label>
                        <input type="radio" id="adminRadio" name="userType" value="Admin">
                        <label for="adminRadio" id="adminLabel" class="radioLabel">Admin</label>
                    </div>

                    <p class="errormsg" id="errorOverall">Invalid Username or Password</p>

                    <label for="userName">Username</label>
                    <input type="text" id="userName" name="userName" required>
                    <p class="errormsg" id="errorUser">Only letters (a-z, A-Z), numbers, underscores
                        and full stops are allowed</p>

                    <label for="Password">Password</label>
                    <input type="password" id="Password" name="Password" required>
                    <div class="showPw">
                        <input type="checkbox" onclick="showPW()" class="showPwCheckBox">
                        <label class="showPwLabel">Show Password</label>
                    </div>
                    <p class="errormsg errorPw">Error Message</p>
                </form>

                <div class="stickToBtm">
                    <button id="signinFormBtn" class="button" type="submit" form="signinForm" value="Submit"
                        disabled>Sign In</button>
                    <p class="registerlogin">No account? <a href="register.php">Register Here!</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        //Define variables
        var nameNode = document.getElementById('userName');
        //nameNode.addEventListener("change", checkName);
        nameNode.addEventListener("keyup", validateForm);

        var pwNode = document.getElementById('Password');
        //pwNode.addEventListener("change", validateForm);
        pwNode.addEventListener("keyup", validateForm);

        var errorOverall = document.getElementById('errorOverall');
        var errorUser = document.getElementById("errorUser");

        var submitButton = document.getElementById("signinFormBtn");

        //Functions
        function validateForm() {
            errorOverall.style.visibility = 'hidden';

            if (checkName() && pwNode.value !== "" && nameNode.value !== "") {
                submitButton.removeAttribute("disabled");
                return true;

            } else {
                submitButton.setAttribute("disabled", "true");
                return false;
            }
        }

        function checkName(event) {
            errorOverall.style.visibility = 'hidden';

            var name = nameNode.value;

            var regexp = /^[A-Za-z\.\_0-9]*$/;
            var pos = regexp.test(name);

            if (name == "") {
                return false;

            } else if (!pos) {
                errorUser.style.visibility = "visible";
                nameNode.classList.add("error-border");
                return false;

            } else {
                errorUser.style.visibility = "hidden";
                nameNode.classList.remove("error-border");
                return true;
            }
        }

        function showPW() {
            if (pwNode.type === "password") {
                pwNode.type = "text";
            } else {
                pwNode.type = "password";
            }
        }

        <?php
        include '../PHP_Function/db_connection.php';

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userType = $_POST['userType'];
            $name = $_POST['userName'];
            $pw = $_POST['Password'];

            $sql = "";

            //Perform checking with SQL Db
            if ($userType == 'User') {
                $sql = $conn->prepare("SELECT * FROM users WHERE userName=? AND pw =?;");

            } else if ($userType == "Admin") {
                $sql = $conn->prepare("SELECT * FROM admins WHERE adminName=? AND pw =?;");
            }

            $sql->bind_param("ss", $name, $pw);
            $sql->execute(); // Execute the prepared statement      
        
            $result = $sql->get_result(); // Get the result set from the executed statement   
        
            if ($result->num_rows > 0) {
                $id = -1;

                while ($row = $result->fetch_assoc()) {
                    $id = $row['userId'];
                }

                //Correct username and pw                 
                if ($userType == "User") {
                    //Create Session                    
                    $_SESSION['name'] = $name;
                    $_SESSION['userId'] = $id;

                    echo "window.location.href = 'home.php';";

                } else if ($userType == "Admin") {
                    echo "window.location.href = ''";
                }

            } else {
                //Wrong username and pw  
                //Display the previous input    
                echo "nameNode.value = '$name';";
                //echo "pwNode.value = '$pw';";
                echo "nameNode.focus();";
                echo "nameNode.select();";

                echo "errorOverall.style.visibility = 'visible';";
                echo "submitButton.setAttribute('disabled', 'true');";
            }

            $sql->close();
            $conn->close();
        }
        ?>

    </script>
</body>

</html>