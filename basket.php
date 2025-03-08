<?php
session_start(); // start a session 
include("db.php"); //include db.php file to connect to DB
$pagename="Smart Basket"; //Create and populate a variable called $pagename

echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; //Call in stylesheet
echo "<title>".$pagename."</title>"; //display name of the page as window title

echo "<body>";

include ("headfile.html"); //include header layout file

echo "<h4>".$pagename."</h4>"; //display name of the page on the web page
//display random text

if (isset($_POST['h_prodid'])){
    //capture the id of selected product using the POST method and $_POST superglobal variable
    //and store it in a new local variable called $newprodid
    $newprodid=$_POST['h_prodid'];

    //capture the required quantity of selected product using the POST method and $_POST superglobal variable
    //and store it in a new local variable called $reququantity
    $reququantity=$_POST['p_quantity'];


    //Display id of selected product
    echo "<p>Id of selected product: ".$newprodid;


    //Display quantity of selected product
    echo "<br>Quantity of selected product: ".$reququantity;


    // create a session to store the product id and quantity
    $_SESSION['basket'][$newprodid]=$reququantity; // $_SESSION['basket'] is an array that stores the product id and quantity
    // $newprodid is the product id and $reququantity is the quantity of the product
    // What it does:
    // It assigns the quantity ($reququantity) to the product with ID ($newprodid) in the basket array.
    // For example, if $newprodid is 5 and $reququantity is 3,
    // it saves $_SESSION['basket'][5] = 3; meaning product 5 has a quantity of 3 in the basket.
    // echo "<p> 1 item added to the basket</p>";

    echo "<p>1 item added to the basket</p>";

}else {
    echo "<p>Current basket unchanged</p>";
}




include("footfile.html"); //include head layout
echo "</body>";
?>