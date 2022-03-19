<?php
session_start();
include('db.php');
$status="";
if (isset($_POST['Product ID']) && $_POST['Product ID']!=""){
$ID = $_POST['Product ID'];
$result = mysqli_query(
$con,
"SELECT * FROM `products` WHERE `Product ID`='$ID'"
);
$row = mysqli_fetch_assoc($result);
$name = $row['Name'];
$ID = $row['Product ID'];
$price = $row['price'];

$cartArray = array(
	$code=>array(
	'name'=>$name,
	'Product ID'=>$ID,
	'price'=>$price,
	'quantity'=>1)
);

if(empty($_SESSION["shopping_bag"])) {
    $_SESSION["shopping_bag"] = $cartArray;
    $status = "<div class='box'>Product is added to your cart!</div>";
}else{
    $array_keys = array_keys($_SESSION["shopping_cart"]);
    if(in_array($code,$array_keys)) {
	$status = "<div class='box' style='color:red;'>
	Product is already added to your cart!</div>";	
    } else {
    $_SESSION["shopping_bag"] = array_merge(
    $_SESSION["shopping_bag"],
    $cartArray
    );
    $status = "<div class='box'>Product is added to your cart!</div>";
	}

	}
}
?>
<?php
if(!empty($_SESSION["shopping_cart"])) {
$cart_count = count(array_keys($_SESSION["shopping_cart"]));
?>
<div class="cart_div">
<a href="cart.php"><img src="cart-icon.png" /> Cart<span>
<?php echo $cart_count; ?></span></a>
</div>
<?php
}
?>
<?php
$result = mysqli_query($con,"SELECT * FROM `products`");
while($row = mysqli_fetch_assoc($result)){
    echo "<div class='product_wrapper'>
    <form method='post' action=''>
    <input type='hidden' name='code' value=".$row['code']." />
    <div class='image'><img src='".$row['image']."' /></div>
    <div class='name'>".$row['name']."</div>
    <div class='price'>$".$row['price']."</div>
    <button type='submit' class='buy'>Buy Now</button>
    </form>
    </div>";
        }
mysqli_close($con);
?>

<div style="clear:both;"></div>

<div class="message_box" style="margin:10px 0px;">
<?php echo $status; ?>
</div>

