<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\facades\DB;

class CartController extends Controller
{
    //

    public function cart(){

        return view('cart');
    }
public function add_to_cart( request $request){

    if($request->session()->has('cart')){

$cart = $request->session()->get('cart');
$products_array_ids =array_column($cart,'id');
$id =$request->input('id'); 
if(!in_array($id,$products_array_ids)){
    $name = $request->input('name');
    $image = $request->input('image');
    $price = $request->input('price');
    $quantity = $request->input('quantity');
    $sale_price = $request->input('sale_price');
if($sale_price != null){
    $price_to_charge = $sale_price;
}
else{
    $price_to_charge = $price;

}

$product_array = array(
    'id'=>$id,
    'name'=>$name,
    'image'=>$image,
    'price'=>$price_to_charge,
    'quantity'=>$quantity,
 
);
$cart[$id] = $product_array;
$request->session()->put('cart',$cart);


}else{
echo "<script>alert('product is already in the cart')</script>";

    }

$this->calculatetotalcart($request);

return view('cart');
    
}
else{
$cart = array();

    $id = $request->input('id');
    $name = $request->input('name');
    $image = $request->input('image');
    $price = $request->input('price');
    $quantity = $request->input('quantity');
    $sale_price = $request->input('sale_price');
    if($sale_price != null){
        $price_to_charge = $sale_price;
    }
    else{
        $price_to_charge = $price;
    
    }
    
    $product_array = array(
        'id'=>$id,
        'name'=>$name,
        'image'=>$image,
        'price'=>$price_to_charge,
        'quantity'=>$quantity,
     
    );
    $cart[$id] = $product_array;
    $request->session()->put('cart',$cart);

$this->calculatetotalcart($request);

    return view('cart');

}
}

function calculatetotalcart( request $request){
    $cart = $request->session()->get('cart');
    $total_price =0;
    $total_quantity =0;

foreach($cart as $id =>$product){
$product = $cart[$id];
$price = $product['price'];
$quantity = $product['quantity'];

$total_price = $total_price + ($price*$quantity);
$total_quantity =$total_quantity + $quantity;
}

    $request->Session()->put('total',$total_price);
    $request->Session()->put('quantity',$total_quantity);

}

 function remove_from_cart( request $request){
    if($request->session()->has('cart')){
        $id = $request->input('id');
        $cart = $request->session()->get('cart');
        unset($cart[$id]);
        $request->session()->put('cart',$cart);
        $this->calculatetotalcart($request);

    }
    return view('cart');

 }


  function edit_product_quantity( request $request){
    if($request->session()->has('cart')){
        $product_id = $request->input('id');
        $product_quantity = $request->input('quantity');
if($request->has('decrease_product_quantity_btn')){
    $product_quantity = $product_quantity - 1;
} elseif($request->has('increase_product_quantity_btn')){
    $product_quantity = $product_quantity + 1;

}
 if($product_quantity <=0){
    $this->remove_from_cart($request);

 }



        $cart = $request->session()->get('cart');
if(array_key_exists($product_id, $cart)){
    $cart[$product_id]['quantity'] = $product_quantity;
    $request->session()->put('cart',$cart);
    $this->calculatetotalcart($request);


}
}
return view('cart');
  

}
  
function checkout(){
    return view('checkout');

}


function place_order( request $request){

    if($request->session()->has('cart')){
        $name = $request->input('name');
        $email = $request->input('email');
        $city = $request->input('city');
        $address = $request->input('address');
        $phone = $request->input('phone');

        $cost =$request->session()->get('total');
        $status = "Not paid";
        $date = date('y-m-d');



        $cart = $request->session()->get('cart');

      $order_id =  DB::table('orders')->InsertGetId([
            
            'name'=>$name,
            'email'=>$email,
            'city'=>$city,
            'address'=>$address,
            'phone'=>$phone,
            'cost'=>$cost,
            'status'=>$status,
            'date'=>$date


        ],'id');

        foreach ($cart as $id => $product) {

            $product =$cart[$id];
            $product_id = $product['id'];
            $product_name = $product['name'];
            $product_price = $product['price'];
            $product_quantity = $product['quantity'];
            $product_image = $product['image'];
        }

        DB::table('order_items')->insert([

            'product_id'=>$product_id,
            'order_id'=>$order_id,
            'product_name'=>$product_name,
            'product_price'=>$product_price,
            'product_image'=>$product_image,
            'product_quantity'=>$product_quantity,       
            'order_date'=>$date


        ]);

        $request->session()->put('order_id',$order_id);

        return view('payment');



    }else{
        return redirect('/');

    }
}




















}
