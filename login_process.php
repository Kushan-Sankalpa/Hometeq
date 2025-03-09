<?php
session_start(); //start the session
$pagename = "Login process "; //Create and populate a variable called $pagename
include("db.php"); //include db.php file to connect to DB

echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; //Call in stylesheet
echo "<title>".$pagename."</title>"; //display name of the page as window title

echo "<body>";

include("headfile.html"); //include header layout file

echo "<h4>".$pagename."</h4>"; //display name of the page on the web page

//capture the 2 values entered by the user in the form using the $_POST superglobal variable
//assign these 2 values to 2 local variables
$email = $_POST['l_email']; // when i click sumbit the data is sent to the post array by l_email variable and l_passwordbb by this i get the data and assign to a varible 
$password = $_POST['l_password'];


if (empty($email) or empty($password)) //if either the $email or the $password is empty
{
    echo "<p><b>Login failed!</b>"; //display login error
    echo "<br>login form incomplete";
    echo "<br>Make sure you provide all the required details</p>";
    echo "<br><p> Go back to <a href=login.php>login</a></p>";
}
else
{
    $SQL = "SELECT * FROM Users WHERE userEmail = '".$email."'"; //retrieve record if email matches
    $exeSQL = mysqli_query($conn, $SQL) or die (mysqli_error($conn)); //execute SQL query , mysqli_querry is used to send the query to the database and fetch the data and store ias objet 
    $nbrecs = mysqli_num_rows($exeSQL); //retrieve the number of records form the data came from querry 
                                        // this is for the email entered by the user if the email is not present in the database then the number of records will be 0
                                        // check weather the enterd email is present in the database or not

    if ($nbrecs == 0) //if nb of records is 0 i.e. if no records were located for which email matches entered email
    {
        echo "<p><b>Login failed!</b>"; //display login error
        echo "<br>Email not recognised</p>";
        echo "<br><p> Go back to <a href=login.php>login</a></p>";

    }
    else
    {
        // if the email is present in the database or $nbrecs is not 0
        $arrayuser = mysqli_fetch_array($exeSQL); //create array of user for this email
                                                // fetch the data from the $exeSQL object and store in the array

        if ($arrayuser['userPassword'] <> $password) //campre the password in array and eneterd array
                                                        // this <> is like != in php
                                                        //<> = not equal

        {
            echo "<p><b>Login failed!</b>"; //display login error
            echo "<br>Password not valid</p>";
            echo "<br><p> Go back to <a href=login.php>login</a></p>";
        }
        else
        {
            echo "<p><b>Login success</b></p>"; //display login success
            $_SESSION['userid'] = $arrayuser['userId']; //create session variable to store the user id
            $_SESSION['fname'] = $arrayuser['userFName']; //create session variable to store the user first name
            $_SESSION['sname'] = $arrayuser['userSName']; //create session variable to store the user surname
            $_SESSION['usertype'] = $arrayuser['userType']; //create session variable to store the user type
            echo "<p>Welcome, ". $_SESSION['fname']." ".$_SESSION['sname']."</p>"; //display welcome greeting

            if ($_SESSION['usertype'] == 'C') //if user type is C, they are a customer
            {
                echo "<p>User Type: homteq Customer</p>";
            }
            if ($_SESSION['usertype'] == 'A') //if user type is A, they are an admin
            {
                echo "<p>User type: homteq Administrator</p>";
            }

            echo "<br><p>Continue shopping for <a href=index.php>Home Tech</a>";
            echo "<br>View your <a href=basket.php>Smart Basket</a></p>";
        }
    }
}

include("footfile.html"); //include head layout
echo "</body>";
?>
