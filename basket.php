<?php
session_start(); // start a session 


include("db.php"); //include db.php file to connect to DB
$pagename="Clear Smart Basket"; //Create and populate a variable called $pagename

echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; //Call in stylesheet
echo "<title>".$pagename."</title>"; //display name of the page as window title

echo "<body>";

include ("headfile.html"); //include header layout file

echo "<h4>".$pagename."</h4>"; //display name of the page on the web page

//if the value of the product id to be deleted (which was posted through the hidden field) is set
if (isset($_POST['del_prodid']))
    {
    //capture the posted product id and assign it to a local variable $delprodid
    $delprodid=$_POST['del_prodid'];
    //unset the cell of the session for this posted product id variable
    unset ($_SESSION['basket'][$delprodid]);
    //display a "1 item removed from the basket" message
    echo "<p>1 item removed";
    }



//This checks if the form (from a previous page) has sent a product ID (h_prodid) using the POST method. If yes, it means the user is adding a new product to the basket.
if (isset($_POST['h_prodid'])) //The isset() function checks whether a variable is set, which means that it has to be declared and is not NULL.
                                //This isset() function returns true if the variable exists and is not NULL, otherwise it returns false.
                                // if i directly come to this page without adding any it should show the added one or a empty basket that why i used this 
{
    //capture the ID of selected product using the POST method and the $_POST superglobal variable
    //and store it in a new local variable called $newprodid
    $newprodid=$_POST['h_prodid']; // if user click addto basket button in proid = 1 the h_prodid = 1  and in this part assign that val to newprodid

    //capture the required quantity of selected product using the POST method and $_POST superglobal variable
    //and store it in a new local variable called $reququantity
    $reququantity=$_POST['p_quantity']; // if user clci the add to basket button the p_quantity = 1 

    
    //create a new cell in the basket session array. Index this cell with the new product id.
    //Inside the cell store the required product quantity
    $_SESSION['basket'][$newprodid]=$reququantity; //This saves the product in a session array called basket:
                                                  //For example, if product 1 is chosen with quantity 2, it stores $_SESSION['basket'][1] = 2.
   
    echo "<p>1 item added";
}
    //else
    //Display "Current basket unchanged " message
else
{
    echo "<p>Basket unchanged";
}

$total= 0; //Create a variable $total and initialize it to zero
//Create HTML table with header to display the content of the basket: prod name, price, selected quantity and subtotal
echo "<p><table id='baskettable'>";
echo "<tr>";
echo "<th>Product Name</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Remove Products</th>";
echo "</tr>";
//if the session array $_SESSION['basket'] is set
if (isset($_SESSION['basket'])) //This checks if the basket exists in the session. If it does, we will list its contents.
{
    //loop through the basket session array for each data item inside the session using a foreach loop 
    //to split the session array between the index and the content of the cell
    //for each iteration of the loop
    //store the id in a local variable $index & store the required quantity into a local variable $value
    foreach($_SESSION['basket'] as $newprodid => $reququantity) // This loop goes through each item in the basket and displays it.
                                                                //  $newprodid is the key and $reququantity is the value.
                                                                //  For example, if the basket has product 1 with quantity 2, $newprodid will be 1 and $reququantity will be 2.
    {
        //SQL query to retrieve from Product table details of selected product for which id matches $newprodid
        //execute query and create array of records $arrayp
        $SQL="select prodId, prodName,prodPrice from product where prodId=".$newprodid;

        $exeSQL=mysqli_query($conn, $SQL) or die (mysqli_error($conn));

        $arrayp=mysqli_fetch_array($exeSQL);
        echo "<tr>";
        //display product name & product price using array of records $arrayp
        echo "<td>".$arrayp['prodName']."</td>";
        echo "<td>&pound".number_format($arrayp['prodPrice'],2)."</td>";
        // display selected quantity of product retrieved from the cell of session array and now in $reququantity
        echo "<td style='text-align:center;'>".$reququantity."</td>";
        //calculate subtotal, store it in a local variable $subtotal and display it
        $subtotal=$arrayp['prodPrice'] * $reququantity;
        echo "<td>&pound".number_format($subtotal,2)."</td>";
         // --- NEW CODE: Add a REMOVE button for this item ---
         echo "<td>";
         echo "<form action='basket.php' method='post'>";
         echo "<input type='submit' value='Remove' id='submitbtn'>";
         echo "<input type='hidden' name='del_prodid' value='".$newprodid."'>";
         echo "</form>";
         echo "</td>";
         // --- END NEW CODE: Add a REMOVE button for this item ---
        
         echo "</tr>";
        
        //increase total by adding the subtotal to the current total
        $total=$total+$subtotal;
    }
}
//else display empty basket message
else 
{
    echo "<p>Empty basket";
}
// Display total
echo "<tr>";
echo "<td colspan=3>TOTAL</td>";
echo "<td>&pound".number_format($total,2)."</td>";
echo "</tr>";
echo "</table>";

echo "<br><p><a href='clearbasket.php'>CLEAR BASKET</a></p>";

echo "<br><p>New homteq customers: <a href='signup.php'>Sign up</a></p>";
echo "<p>Returning homteq customers: <a href='login.php'>Login</a></p>";

include("footfile.html"); //include footer layout file
echo "</body>";
?>
