<?php


class Cart 
{
	function add_to_cart($user_id,$product_id,$quantity)
	{
        ////////check if the product exist in the cart ////////////
		$product_exeist = DB::getInstance()->select('quantity','cart','product_id='.$product_id.' and user_id = '.$user_id.' ');
		///////// if product exeist in cart increse its quantity by the new quantity 
		if ($product_exeist) {
			$quantity += $product_exeist[0]['quantity'];
			DB::getInstance()->update('cart','quantity='.$quantity.' ','product_id='.$product_id.'');
			$this->update_cart_data($user_id);
			return header('location:../view/cart.php');
			/////////if product don't exeist in cart then add it 
		}else{
			DB::getInstance()->insert('cart',array('user_id','product_id','quantity'),array("'$user_id","$product_id","$quantity'"));
			$this->update_cart_data($user_id);
			return header('location:../view/cart.php');
		}
	}


  ///////////////function to check if a spacif product related to offer/////////////////////
	function check_product_offers($product_id)
	{
		$offers = DB::getInstance()->select('*','promotions left join promotions_rules on promotions.promotion_id = promotions_rules.promotions_id');
		 //////// loping throw offers to check if there is any related offers to spacifc porduct 
		foreach ($offers as $key => $offer) {
			if ($offer['product_id'] == $product_id) {
     return $offer['promotion_id'];// return offer id if the prdouct related to the offer 
     }
   }
   ///// else whill return false
     return false;

   }


////////////////function to get all related offers to all prdouct in the cart///////////
function related_cart_offers($cart_data =array())
{
	$applyed_offers = array();
	foreach ($cart_data as $key => $data) {
		if($offer = $this->check_product_offers($data['product_id']))
		{
			if (in_array($offer, $applyed_offers)){}
				else{
					$applyed_offers[]=$offer;
				}

			}
		}
		return $applyed_offers;	
	}

	function check_offer_rules($offer_id,$products_in_cart)
	{
		$product_found_flag=0;
		$offer_rules = DB::getInstance()->select('*','promotions_rules','promotions_id="'.$offer_id.'"');
		foreach ($offer_rules as $key => $offer) {
			foreach ($products_in_cart as $key => $product) {
				if ($product['product_id'] == $offer['product_id'] && $product['quantity']>=$offer['quantity']) {
					$product_found_flag=1;
					break;
				}
			}
			if ($product_found_flag==1) {
				$product_found_flag=0;
			}else
			{
				return 0;
			}
		}
		return 1;
	}

	function update_cart_data($user_id)
	{
		$offers_to_be_discount =array();
		$cart_data = DB::getInstance()->select('*','cart left join products on cart.product_id = products.product_id','user_id="'.$user_id.'"');
		$related_offers = $this->related_cart_offers($cart_data);
		foreach ($related_offers as $key => $offer) {
			if($this->check_offer_rules($offer,$cart_data))
			{
				$offers_to_be_discount[]=$offer;
			}
		}
		$offers_ids='';
		$counter =1;
		$count = count($offers_to_be_discount);
		if ($count) {
			foreach ($offers_to_be_discount as  $value) {
				if ($counter<$count) {
					$offers_ids.=$value.',';
					$counter++;
				}else{
					$offers_ids.=$value;
				}
			}

			$offers_data = DB::getInstance()->select('*','promotions left join products on promotions.product_id = products.product_id','promotion_id in ('.$offers_ids.') ');
		}


		$_SESSION['offers_data']=$offers_data;
		$_SESSION['cart'] = $cart_data;
	}


	function change_currency($currency_id)
	{
		$currency = DB::getInstance()->select('*','currency','currency_id='.$currency_id.' ');
		$_SESSION['currance_value'] = $currency[0]['value'];
		$_SESSION['currance_sign'] = $currency[0]['sign'];
		return header('location:../view/cart.php');
	}



}

