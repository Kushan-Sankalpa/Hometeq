<?php
include("db.php"); // Connect to the database
$pagename = "A smart buy for a smart home"; 
echo "<link rel='stylesheet' type='text/css' href='mystylesheet.css'>";
echo "<title>".$pagename."</title>";
echo "<body>";

include("headfile.html"); // Common header layout
echo "<h4>".$pagename."</h4>";

// 1. Retrieve the product ID from the URL
$prodid = $_GET['prodid'];  // after i click the prduct id will be 1 or any id 
echo "<p>Selected product Id: ".$prodid."</p>";

// 2. Build the SQL query to get product details
$SQL = "SELECT prodId, prodName, prodPicNameLarge, prodDescripLong, prodPrice, prodQuantity 
        FROM product 
        WHERE prodId=".$prodid; 

// 3. Execute the query
$exeSQL = mysqli_query($conn, $SQL) or die(mysqli_error($conn));

// 4. Start displaying the product in a table
echo "<table style='border:0px'>";

// 5. Loop through the result (should be one product, but we use a loop just in case)
while ($arrayp = mysqli_fetch_array($exeSQL)) {

    echo "<tr>";

    // LEFT CELL: Large Image
    echo "<td style='border:0px; vertical-align:top;'>";
    // If you want the large image clickable, you can wrap it in <a> ... </a>. Otherwise, just display the image:
    echo "<img src='images/".$arrayp['prodPicNameLarge']."' height='400' width='400'>";
    echo "</td>";

    // RIGHT CELL: Name, Description, Price, and Stock
    echo "<td style='border:0px; vertical-align:top; padding-left:20px;'>";

    // Product Name
    echo "<h2>".$arrayp['prodName']."</h2>";

    // Long Description
    echo "<p>".$arrayp['prodDescripLong']."</p>";

    // Product Price
    echo "<p><strong>Price:</strong> £".$arrayp['prodPrice']."</p>";

    // Quantity in Stock
    echo "<p><strong>Number in stock:</strong> ".$arrayp['prodQuantity']."</p>";

    echo "<br><p>Number to be purchased: ";

    
    echo "<form action=basket.php method=post>";
    
    //dropdown list for quantity
    echo "<select name=p_quantity>";

    // create a loop to show the quantity of the product in stock
    for ($i=1; $i<=$arrayp['prodQuantity']; $i++)
    {
        echo "<option value=".$i.">".$i."</option>";
    }

    echo "</select>";

    echo "<input type=submit name='submitbtn' value='ADD TO BASKET' id='submitbtn'>";
    //pass the product id to the next page basket.php as a hidden value
    echo "<input type=hidden name=h_prodid value=".$prodid.">";
    echo "</form>";
    echo "</p>";

    echo "</td>";

    echo "</tr>";

   
}

echo "</table>";


include("footfile.html"); // Common footer layout
echo "</body>";
?>
