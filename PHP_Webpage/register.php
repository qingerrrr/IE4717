<?php
//Ensure user is not logged in
session_start();

if (isset($_SESSION["name"]) || isset($_SESSION["adminName"])) {
    echo 'Direct access not permitted.';
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
    <link rel="stylesheet" href="../CSS/register.css">
</head>

<body>
    <div class="flex-container">
        <div class="bookLeft">
            <h1>DUNOT</h1>
            <p>Where Imaginations Come to Life</p>
        </div>

        <div class="bookRight">
            <div class="rightContent">
                <h2>User Registration</h2>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="registerForm">
                    <label for="userName">Username</label>
                    <input type="text" id="userName" name="userName">
                    <p class="errormsg" id="errorUser">Min length of 3 characters. Only letters (a-z, A-Z), numbers,
                        underscores
                        and full stops are allowed</p>


                    <label for="Password">Password</label>
                    <input type="password" id="Password" name="Password">
                    <div class="showPw">
                        <input type="checkbox" onclick="showPW('Password')" class="showPwCheckBox">
                        <label class="showPwLabel">Show Password</label>
                    </div>
                    <p class="errormsg" id="errorPw">Min length of 8 characters. Contains at least a uppercase
                        letter, a
                        lowercase letter, a special character and a number</p>


                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword">
                    <div class="showPw">
                        <input type="checkbox" onclick="showPW('confirmPassword')" class="showPwCheckBox">
                        <label class="showPwLabel">Show Password</label>
                    </div>
                    <p class="errormsg" id="errorConfirmPW">Confirmation password is different from the password</p>

                </form>

                <div class="stickToBtm">
                    <button class="button" type="submit" form="registerForm" value="Submit" id="registerFormBtn"
                        disabled>Let's Embark</button>
                    <p class="registerlogin">Have an account? <a href="index.php">Log In Here!</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        //Define variables
        var nameNode = document.getElementById('userName');
        nameNode.addEventListener("keyup", validateForm);
        nameNode.addEventListener("change", checkName);

        var pwNode = document.getElementById('Password');
        pwNode.addEventListener("keyup", validateForm);
        pwNode.addEventListener("change", checkPw);

        var confirmPwNode = document.getElementById('confirmPassword');
        confirmPwNode.addEventListener("keyup", validateForm);
        confirmPwNode.addEventListener("change", checkConfirmPw);

        var errorUser = document.getElementById("errorUser");
        var errorPw = document.getElementById("errorPw");
        var errorConfirmPW = document.getElementById("errorConfirmPW");

        var submitButton = document.getElementById("registerFormBtn");

        //Functions
        function validateForm() {
            if (checkName() && checkPw() && checkConfirmPw()) {
                submitButton.removeAttribute("disabled");
                return true;

            } else {
                submitButton.setAttribute("disabled", "true");
                return false;
            }
        }

        function checkName(event) {
            var name = nameNode.value;

            var regexp = /^[A-Za-z\.\_0-9]{3,}$/;
            var pos = regexp.test(name);

            if (name == "") {
                return false;

            } else if (!pos) {
                //Not match
                errorUser.style.visibility = "visible";
                errorUser.textContent = 'Min 3 in length, only letters (a-z, A-Z), numbers, underscores and full stops are allowed';
                nameNode.classList.add("error-border");

                return false;

            } else {
                errorUser.style.visibility = "hidden";
                nameNode.classList.remove("error-border");
                return true;
            }
        }

        function checkPw(event) {
            var pw = pwNode.value;

            var regexp = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            var pos = regexp.test(pw);

            if (pw == "") {
                // errorPw.style.visibility = "visible";
                // errorPw.textContent = "Please fill this up";
                // pwNode.focus();
                // pwNode.select();
                return false;

            } else if (!pos) {
                errorPw.style.visibility = "visible";
                pwNode.classList.add("error-border");
                //pwNode.focus();
                //pwNode.select();
                return false;

            } else {
                errorPw.style.visibility = "hidden";
                pwNode.classList.remove("error-border");
                return true;
            }
        }

        function checkConfirmPw() {
            var confirmPw = confirmPwNode.value;
            var regexp = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            var pos = regexp.test(confirmPw);

            if (confirmPw == "") {
                return false;

            } else if (pwNode.value !== confirmPw) {
                errorConfirmPW.style.visibility = "visible";
                errorConfirmPW.textContent = "Confirmation password mismatch";
                confirmPwNode.classList.add("error-border");

                //confirmPwNode.focus();

                return false;

            } else if (!pos) {
                errorConfirmPW.style.visibility = "visible";
                errorConfirmPW.textContent = "Min length of 8 characters. Contains at least a uppercase letter, a lowercase letter, a special character and a number";
                confirmPwNode.classList.add("error-border");

                //confirmPwNode.focus();
                return false;

            } else {
                errorConfirmPW.style.visibility = "hidden";
                confirmPwNode.classList.remove("error-border");
                return true;
            }
        }

        function showPW(id) {
            var node = document.getElementById(id);

            if (node.type === "password") {
                node.type = "text";
            } else {
                node.type = "password";
            }
        }


        <?php
        include '../PHP_Function/db_connection.php';

        // // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['userName'];
            $pw = $_POST['Password'];
            $pw2 = $_POST['confirmPassword'];

            $sql = "";

            //Perform checking with SQL Db
            $sql = $conn->prepare("SELECT * FROM users WHERE userName=?;");
            $sql->bind_param("s", $name);
            $sql->execute(); // Execute the prepared statement      
        
            $result = $sql->get_result(); // Get the result set from the executed statement                                 
        
            if ($result->num_rows === 0) {
                //Can Insert
                $sql = $conn->prepare("INSERT INTO users (username, pw) VALUES (?, ?)");
                $sql->bind_param("ss", $name, $pw);
                $sql->execute();

                //Create Session                
                $_SESSION['name'] = $name;

                echo "window.location.href = 'home.php'";

            } else {
                //Fail Insert                                    
                echo "errorUser.style.visibility = 'visible';\n";
                echo "errorUser.textContent = 'User Name already exists';\n";
                echo "nameNode.value = '$name';\n";
                echo "nameNode.focus();\n";
                echo "nameNode.select();\n";
            }

            $sql->close();
            $conn->close();
        }
        ?>

    </script>
</body>

</html>