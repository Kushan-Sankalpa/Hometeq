<?php
include("db.php"); //include db.php file to connect to DB
$pagename="Smart Basket"; //Create and populate a variable called $pagename

echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; //Call in stylesheet
echo "<title>".$pagename."</title>"; //display name of the page as window title

echo "<body>";

include ("headfile.html"); //include header layout file

echo "<h4>".$pagename."</h4>"; //display name of the page on the web page
//display random text

$newprodid=$_POST['h_prodid'];
//capture the required quantity of selected product using the POST method and $_POST superglobal variable
//and store it in a new local variable called $reququantity
$reququantity=$_POST['p_quantity'];
//Display id of selected product
echo "<p>Id of selected product: ".$newprodid;
//Display quantity of selected product
echo "<br>Quantity of selected product: ".$reququantity;


include("footfile.html"); //include head layout
echo "</body>";
?>