<?php
session_start();  // Start the session
include("db.php");  // Include db.php file to connect to the database

mysqli_report(MYSQLI_REPORT_OFF);  // Deacrivate the default error messages , so i can manually handle them

$pagename="Sign up Results";  // Create and populate a variable called $pagename

// Call in stylesheet and set the page title
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";  
echo "<title>".$pagename."</title>";

// Begin the HTML body
echo "<body>";

include ("headfile.html");  // Include header layout file

echo "<h4>".$pagename."</h4>";  // Display the page name as a heading on the web page

// Capture and trim the 7 inputs entered in the form using the $_POST superglobal variable
// Store these details into 7 local variables
$fname = trim($_POST['r_firstname']);   // trim - Get first name and remove extra white spaces
$lname = trim($_POST['r_lastname']);      // Get last name
$address = trim($_POST['r_address']);       // Get address
$postcode = trim($_POST['r_postcode']);      // Get postcode
$telno = trim($_POST['r_telno']);            // Get telephone number
$email = trim($_POST['r_email']);            // Get email address
$password1 = trim($_POST['r_password1']);    // Get first password
$password2 = trim($_POST['r_password2']);    // Get second password for confirmation

// Define a regular expression to validate the email address format
$reg = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";

// Check if any of the required fields are empty
if (empty($fname) or empty($lname) or empty($address) or empty($postcode) or empty($telno) or empty($email) or empty($password1) or empty($password2))
{  //(hint: use the empty function)
    echo "<p><b>Sign-up failed!</b></p>";
    echo "<br><p>Your signup form is incomplete and all fields are mandatory";
    echo "<br>Make sure you provide all the required details</p>";
    echo "<br><p>Go back to <a href='signup.php'>sign up</a></p>";
    echo "<br><br><br><br>";
}
elseif ($password1 <> $password2)  // Check if the two entered passwords do not match
                                    //hint: compare the 2 password variables using the == operator)
                                    // "<> " == "!="
                                    // if the two strings are not equal then it will return true
{
    echo "<p><b>Sign-up failed!</b></p>";
    echo "<br><p>The 2 passwords are not matching";
    echo "<br>Make sure you enter them correctly</p>";
    echo "<br><p>Go back to <a href='signup.php'>sign up</a></p>";
    echo "<br><br><br><br>";
}
elseif (!preg_match($reg, $email))  // Check if the email does not match the regular expression (i.e., it's not in a valid format)
                                    //hint: use the preg_match function to compare the email address with the regular expression)
                                    // if the email does not match the regular expression then it will return false 
{
    echo "<p><b>Sign-up failed!</b></p>";
    echo "<br><p>Email not valid";
    echo "<br>Make sure you enter a correct email address</p>";
    echo "<br><p>Go back to <a href='signup.php'>sign up</a></p>";
    echo "<br><br><br><br>";
}
else
{
    // Write a SQL query to insert a new user into the Users table
    $SQL = "insert into Users
    (userType, userFName, userSName, userAddress, userPostCode, userTelNo, userEmail, userPassword)
    values
    ('C','".$fname."','".$lname."','".$address."','".$postcode."', '".$telno."', '".$email."', '".$password1."')";

    // Execute the INSERT query
    if (mysqli_query($conn, $SQL))
    {
        // If SQL execution is successful, display a sign-up success message
        echo "<p><b>Sign-up successful!</b></p>";
        echo "<br><p>To continue, please <a href='login.php'>login</a></p>";
    }
    else
    {
        // If SQL execution fails, display a sign-up failure message
        echo "<p><b>Sign-up failed!</b></p>";
        
        // If the error number is 1062, it means the email address already exists (unique constraint violation)
        if (mysqli_errno($conn)==1062) //hint: use the mysqli_errno function and the error number 1062)
        {
            echo "<br><p>Email already in use";
            echo "<br>You may be already registered or try another email address</p>";
        }
        // If the error number is 1064, it indicates invalid characters (e.g., apostrophes or backslashes) were entered
        if (mysqli_errno($conn)==1064)
        {
            echo "<br><p>Invalid characters entered in the form";
            $invalidchars="apostrophes like [ ' ] and backslashes like [ \ ]";
            echo "<br>Make sure you avoid the following characters: ".$invalidchars."</p>";
        }
        echo "<br><p>Go back to <a href='signup.php'>sign up</a></p>";
        echo "<br><br><br><br>";
    }
}

include("footfile.html");  // Include footer layout file
echo "</body>";
?>
