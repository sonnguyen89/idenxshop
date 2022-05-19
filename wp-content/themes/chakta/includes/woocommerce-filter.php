<?php
 
/*************************************************
## Chakta Shop View Grid-List
*************************************************/ 
function chakta_shop_view(){
	$getview  = isset( $_GET['shop_view'] ) ? $_GET['shop_view'] : '';
	if($getview){
		return $getview;
	}
}

