<?php

////////////geting user selected currancy value and sign /////////////////////
require_once '../core/init.php';
if (isset($_SESSION['currance_value'])) {
  $currance_value = $_SESSION['currance_value'];
  $currance_sign  = $_SESSION['currance_sign'];
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Products</title>
  <style type="text/css">

    * {
      box-sizing: border-box;
    }

    /* Create two equal columns that floats next to each other */
    .column {
      float: left;
      width: 50%;
      padding: 10px;
      height: 300px; /* Should be removed. Only for demonstration */
    }

    /* Clear floats after the columns */
    .row:after {
      content: "";
      display: table;
      clear: both;
    }

  </style>
</head>
<body>

  <?php

///////////// intializing bill variabls /////////////////
  $subtotal =0;
  $taxes=0;
  $total=0;
  $dicsount_string ='';
  $single_product_discount =array();
if (isset($_SESSION['cart'])) {   ///////////checking if there is any data inside the cart
  $cart_data = $_SESSION['cart'];

///////////// looping throw cart data to calculat bill details /////////////////////
  foreach ($cart_data as $key => $data) {

//////check if there is a discount for single product //////////////////////
/////note:single product data mean if you have to buy single product to get a discount for that product like shoes 10% discount /////////////////////////

    if($data['single_product_discount']!=0) 
    {
      $dicsount_string=$data['name'].','.$data['price'].','.$data['quantity'].','.$data['single_product_discount'];
$single_product_discount[] = $dicsount_string;//////get list of the product that has single dicount
}

$subtotal+=($data['price']*$data['quantity']); //////calculat the subtotal 
}
$total+=$subtotal;
$taxes = round(($subtotal * 14)/100,2); //////calculat the taxes 
$total+=$taxes;

//////////////////   display the bill details /////////////////
echo '</table></div>';
echo '<div class="column"><h3>your Bill Details</h3>';       
echo 'Subtotal: '.$currance_sign.' '.($subtotal*$currance_value).'<br>';
echo 'Taxes: '.$currance_sign.' '.($taxes*$currance_value).'<br>';

/////////// check if there is any single product discount or a complet offer or both to be displayed ///////////////

if (isset($_SESSION['offers_data']) || !empty($single_product_discount)) {
  echo 'Discounts: <br>';
  if (isset($_SESSION['offers_data']) && !empty($_SESSION['offers_data'])) {
    $offers = $_SESSION['offers_data'];

////////////////// looping throw offer data for calculation///////////////
    foreach ($offers as $key => $offer) {
      $price_affter_dic = (($offer['price'] * $offer['discount'])/100);
      $total-=$price_affter_dic;
      echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$offer['discount'].'% off '.$offer['name'].' -'.$currance_sign.' '.($price_affter_dic*$currance_value).'<br>';
    }
  }

///////////////////////// looping throw single product discount ////////////////
  foreach ($single_product_discount as $key => $single_product_string) {
    $single_product = explode(',', $single_product_string);
    $price_affter_dic = ((($single_product[1]*$single_product[2])*$single_product[3])/100);
    $total-=$price_affter_dic;
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$single_product[3].'% off '.$single_product[0].' -'.$currance_sign.' '.($price_affter_dic*$currance_value).'<br>';           	      
  }
  echo 'Total: '.$currance_sign.' '.($total*$currance_value).'<br>';              
  echo '</div></div>';



}
//////// if there is no offers only total will be displayed with subtotal and taxes ////////
else 
{
  echo 'Total: '.$currance_sign.' '.($total*$currance_value).'<br>';
  echo '</div></div>';	
}

}
?>


</div>

</body>
</html>