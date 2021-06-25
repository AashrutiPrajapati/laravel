<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Customer_address;
use App\Models\CartItem;
use App\Models\CartAddress;
use App\Models\Payment;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderAddress;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CartController extends Controller
{
    public function index(Request $request)
    {
        if (!(session('customerId'))) {
            session(['customerId' => 1]);
            $customerId = session('customerId');
        }
        $model = new Cart;
        $customerId = session('customerId');
        $customer = Customer::where('status', '=', 'Enable')->get();
        $products = Product::where('status', '=', 'Enable')->get();
        $payment = Payment::where('status', '=', 'Enable')->get();
        $shipping = Shipping::where('status', '=', 'Enable')->get();
        $cart = Cart::where('customerId', '=', session('customerId'))->first();
        if ($cart) {
            $billingAddress = CartAddress::where('cartId', '=', $cart->id)->where('addressType', '=', 'Billing')->first();
            $shippingAddress = CartAddress::where('cartId', '=', $cart->id)->where('addressType', '=', 'Shipping')->first();
            if (!$billingAddress) {
                $billingAddress = Customer_address::where('customerId', '=', session('customerId'))->where('addressType', '=', 'Billing')->first();
            }
            if (!$shippingAddress) {
                $shippingAddress = Customer_address::where('customerId', '=', session('customerId'))->where('addressType', '=', 'Shipping')->first();
            }
            $cartItem = CartItem::where('cartId', '=', $cart->id)->first();
            if (!$cartItem) {
                $cartItem = NULL;
            } else {
                $cartItem = CartItem::where('cartId', '=', $cart->id)->get();
            }
            if ($cart['customerId']) {
                $view = view('cart.index', compact('model', 'cartItem', 'products', 'cart', 'payment', 'shipping', 'customer', 'billingAddress', 'shippingAddress'))->render();
                $response = [
                    'element' => [
                        [
                            'success' => 'success',
                            'name' => 'laravel',
                            'selector' => '#content',
                            'html' => $view
                        ]
                    ]
                ];


                header('content-type:application/json');
                echo json_encode($response);
            }
        } else {
            $request->session()->forget('customerId');
            $cart = new cart;
            $cart->save();
            $customerShippingAddress = Customer_address::where('customerId', '=', session('customerId'))->where('addressType', '=', 'Billing')->first();
            $customerBillingAddress = Customer_address::where('customerId', '=', session('customerId'))->where('addressType', '=', 'Shipping')->first();
            $cartItem = NULL;
            $view = view('cart.index', compact('model', 'cartItem', 'products', 'cart', 'payment', 'shipping', 'customer', 'customerBillingAddress', 'customerShippingAddress'))->render();
            $response = [
                'element' => [
                    [
                        'success' => 'success',
                        'name' => 'laravel',
                        'selector' => '#content',
                        'html' => $view
                    ]
                ]
            ];

            header('content-type:application/json');
            echo json_encode($response);
        }
    }

    public function selectCustomer(Request $request)
    {
        session(['customerId' => $request->input('customerId')]);
        $cart=Cart::where('customerId','=',NULL)->first();
        if($cart){
            $cart->customerId = session('customerId');
        }
        else{
            $cart=new Cart;
            $cart->customerId = session('customerId');
        }
        $cart->save();
        return redirect('cart')->with('success', 'Customer selected successfully.');
    }
    public function addProductToCart(Request $request)
    {
        $cart = Cart::where('customerId', '=', session('customerId'))->first();
        $postData = $request->product['add_to_cart'];
        if (empty($postData)) {
            return redirect('cart')->with('error', "No Product is selected to add into cart.");
        } else {
            foreach ($postData as $key => $productId) {
                $product = Product::find($productId);
                $cartItem = CartItem::where('productId', '=', $productId)->where('cartId', '=', $cart->id)->first();
                if ($cartItem) {
                    if ($cartItem->id) {
                        $cartItem->quantity += 1;
                        $cartItem->price = $cartItem->quantity * $cartItem->price;
                        $cartItem->discount = $cartItem->quantity * $product->discount;
                        $cartItem->save();
                    }
                } else {
                    $cartItem = new CartItem;
                    $cartItem->cartId = $cart->id;
                    $cartItem->productId = $productId;
                    $cartItem->basePrice = $product->price;
                    $cartItem->price = ($product->price) * ($product->quantity);
                    $cartItem->discount = $product->discount;
                    $cartItem->save();
                }
            }
        }
        return redirect('cart')->with('success', "Selected Product is successfully added into cart.");
    }

    public function updateQuantity(Request $request)
    {
        $cart = Cart::where('customerId', '=', session('customerId'))->first();
        $quantity = $request->input('quantity');
        foreach ($quantity as $productId => $value) {
            $cartItem = CartItem::where('cartId', '=', $cart->id)->where('productId', '=', $productId)->first();
            $product = Product::find($productId);
            if ($value == 0) {
                $cartItem->delete();
            } else if ($value > 0) {
                $cartItem->productId = $productId;
                $cartItem->quantity = $value;
                $cartItem->price = $product->price * $value;
                $cartItem->discount = $product->discount * $value;
                $cartItem->save();
            }
            else {
                return redirect('cart')->with('error', "Quantity Should Be Positive .");
            }
        }
        if ($request->input('remove')) {
            $remove = $request->input('remove');
            $cartItem->id = $remove;
            foreach ($remove as $key => $value) {
                $cartItem->id = $value;
                $cartItem->delete();
                return redirect('cart')->with('success', 'Product Was Deleted From Cart.');
            }
        }
        return redirect('cart')->with('success', "Quantity updated successfully");
    }

    public function clearCart(Request $request)
    {
        $cart = Cart::where('customerId', '=', session('customerId'))->first();
        $cartItem = CartItem::where('cartId', '=', $cart->id)->get();
        foreach ($cartItem as $key => $value) {
            $value->delete();
        }
        return redirect('cart')->with('success', 'Cart Clear SuccesssFully..');
    }

    public function billingAddress(Request $request)
    {
        $post = $request->billing;
        $cart = Cart::where('customerId', '=', session('customerId'))->first();
        $billingAddress = CartAddress::where('cartId', '=', $cart->id)->where('addressType', '=', 'Billing')->first();
        if ($billingAddress) {
            $billingAddress->address = $post['address'];
            $billingAddress->city = $post['city'];
            $billingAddress->state = $post['state'];
            $billingAddress->country = $post['country'];
            $billingAddress->zipcode = $post['zipcode'];
            $billingAddress->save();
        } else {
            $cartAddress = new CartAddress;
            $cartAddress->cartId = $cart->id;
            $cartAddress->addressType = 'Billing';
            $cartAddress->address = $post['address'];
            $cartAddress->city = $post['city'];
            $cartAddress->state = $post['state'];
            $cartAddress->country = $post['country'];
            $cartAddress->zipcode = $post['zipcode'];
            $cartAddress->save();
        }
        $customerAddress = Customer_address::where('addressType', '=', 'Billing')->where('customerId', '=', session('customerId'))->first();
        if ($request->input('billingSave')) {
            if ($customerAddress) {
                $customerAddress->address = $post['address'];
                $customerAddress->city = $post['city'];
                $customerAddress->state = $post['state'];
                $customerAddress->country = $post['country'];
                $customerAddress->zipcode = $post['zipcode'];
                $customerAddress->save();
            } else {
                $customerAddress = new Customer_address;
                $customerAddress->addressType = 'Billing';
                $customerAddress->customerId = session('customerId');
                $customerAddress->address = $post['address'];
                $customerAddress->city = $post['city'];
                $customerAddress->state = $post['state'];
                $customerAddress->country = $post['country'];
                $customerAddress->zipcode = $post['zipcode'];
                $customerAddress->save();
            }
        }
        return redirect('cart')->with('success', 'Billing Address Saved SuccesssFully..');
    }

    public function shippingAddress(Request $request)
    {
        $post = $request->shipping;
        $cart = Cart::where('customerId', '=', session('customerId'))->first();
        $shippingAddress = CartAddress::where('cartId', '=', $cart->id)->where('addressType', '=', 'Shipping')->first();
        if ($shippingAddress) {
            $shippingAddress->address = $post['address'];
            $shippingAddress->city = $post['city'];
            $shippingAddress->state = $post['state'];
            $shippingAddress->country = $post['country'];
            $shippingAddress->zipcode = $post['zipcode'];
            $shippingAddress->save();
        } else {
            $cartAddress = new CartAddress;
            // print_r($post);die;
            $cartAddress->cartId = $cart->id;
            $cartAddress->addressType = 'Shipping';
            $cartAddress->address = $post['address'];
            $cartAddress->city = $post['city'];
            $cartAddress->state = $post['state'];
            $cartAddress->country = $post['country'];
            $cartAddress->zipcode = $post['zipcode'];
            $cartAddress->save();
        }
        $customerAddress = Customer_address::where('addressType', '=', 'Shipping')->where('customerId', '=', session('customerId'))->first();

        if ($request->input('shippingSave')) {
            if ($customerAddress) {
                $customerAddress->address = $post['address'];
                $customerAddress->city = $post['city'];
                $customerAddress->state = $post['state'];
                $customerAddress->country = $post['country'];
                $customerAddress->zipcode = $post['zipcode'];
                $customerAddress->save();
            } else {
                $customerAddress = new Customer_address;
                $customerAddress->addressType = 'Shipping';
                $customerAddress->customerId = session('customerId');
                $customerAddress->address = $post['address'];
                $customerAddress->city = $post['city'];
                $customerAddress->state = $post['state'];
                $customerAddress->country = $post['country'];
                $customerAddress->zipcode = $post['zipcode'];
                $customerAddress->save();
            }
        }
        if ($request->input('sameAsBilling')) {
            $cart = Cart::where('customerId', '=', session('customerId'))->first();
            $billingAddress = CartAddress::where('addressType', '=', 'Billing')->where('cartId', '=', $cart->id)->first();
            // print_r($billingAddress);die;
            $shippingAddress = CartAddress::where('cartId', '=', $cart->id)->where('addressType', '=', 'Shipping')->first();
            if ($shippingAddress) {
                $shippingAddress->cartId = $cart->id;
                $shippingAddress->address = $billingAddress->address;
                $shippingAddress->city = $billingAddress->city;
                $shippingAddress->state = $billingAddress->state;
                $shippingAddress->country = $billingAddress->country;
                $shippingAddress->zipcode = $billingAddress->zipcode;
                $shippingAddress->addressType = 'Shipping';
                $shippingAddress->same_as_billing = '1';
                $shippingAddress->save();
            } else {
                $shipping = new CartAddress;
                $shipping->cartId = $cart->id;
                $shipping->address = $billingAddress->address;
                $shipping->city = $billingAddress->city;
                $shipping->state = $billingAddress->state;
                $shipping->country = $billingAddress->country;
                $shipping->zipcode = $billingAddress->zipcode;
                $shipping->addressType = 'Shipping';
                $shipping->same_as_billing = '1';
                $shipping->save();
            }
            $customerAddress = Customer_address::where('customerId', '=', session('customerId'))->where('addressType', '=', 'Billing')->first();
            $billingCustomerAddress = CartAddress::where('addressType', '=', 'Billing')->where('cartId', '=', $cart->id)->first();
            if ($customerAddress) {
                $customerAddress->address = $billingCustomerAddress->address;
                $customerAddress->city = $billingCustomerAddress->city;
                $customerAddress->state = $billingCustomerAddress->state;
                $customerAddress->country = $billingCustomerAddress->country;
                $customerAddress->zipcode = $billingCustomerAddress->zipcode;
                $customerAddress->save();
            } else {
                // echo "1";die;
                $customerAddress = new Customer_address;
                $customerAddress->customerId = session('customerId');
                $customerAddress->address = $billingCustomerAddress->address;
                $customerAddress->city = $billingCustomerAddress->city;
                $customerAddress->state = $billingCustomerAddress->state;
                $customerAddress->country = $billingCustomerAddress->country;
                $customerAddress->zipcode = $billingCustomerAddress->zipcode;
                $customerAddress->addressType = 'Shipping';
                // print_r($customerAddress);die;
                $customerAddress->save();
            }
        }
        return redirect('cart')->with('success', 'Shipping Address Saved SuccesssFully..');
    }

    public function payment(Request $request)
    {
        $payment = $request->payment;
        $cart = Cart::where('customerId', '=', session('customerId'))->first();
        foreach ($payment as $key => $value) {
            $cart->paymentMethodId = $value;
            $cart->save();
        }
        return redirect('cart')->with('success', 'PaymentMethod Saved SuccesssFully..');
    }

    public function shipping(Request $request)
    {
        $shippingId = $request->input('shipping');
        $shipping = Shipping::where('status', '=', 'Enable')->get();
        $cart = Cart::where('customerId', '=', session('customerId'))->first();
        $cart->shippingMethodId = $shippingId;
        foreach ($shipping as $key => $value) {
            if ($value->id == $shippingId) {
                $cart->shippingAmount = $value->amount;
            }
        }
        $cart->save();
        return redirect('cart')->with('success', 'ShippingCharge Saved SuccesssFully..');
    }

    public function placeOrder()
    {
        $cart = Cart::where('customerId', '=', session('customerId'))->first();
        // print_r($cart);die;
        $cartItem = CartItem::where('cartId', '=', $cart->id)->get();
        $cartAddress = CartAddress::where('cartId', '=', $cart->id)->get();
        $order = new Order;
        $order_item = new OrderItem;
        $order_address = new OrderAddress;
        $products = Product::where('status', '=', 'enable')->get();
        $model = new Order;
        $customerName = Customer::where('id', '=', $cart->customerId)->first();
        $paymentMethod = Payment::where('id', '=', $cart->paymentMethodId)->first();
        $shippingMethod = Shipping::where('id', '=', $cart->shippingMethodId)->first();
        $billingAddress = CartAddress::where('cartId', '=', $cart->id)->where('addressType', '=', 'Billing')->first();
        $shippingAddress = CartAddress::where('cartId', '=', $cart->id)->where('addressType', '=', 'Shipping')->first();
        if (!$billingAddress) {
            $billingAddress = Customer_address::where('customerId', '=', session('customerId'))->where('addressType', '=', 'Billing')->first();
        }
        if (!$shippingAddress) {
            $shippingAddress = Customer_address::where('customerId', '=', session('customerId'))->where('addressType', '=', 'Shipping')->first();
        }
        $id = $order->insertGetId(
            [
                'customerId' => $cart->customerId,
                'total' => $cart->total,
                'discount' => $cart->discount,
                'paymentMethodId' => $cart->paymentMethodId,
                'shippingMethodId' => $cart->shippingMethodId,
                'shippingAmount' => $cart->shippingAmount,
                'created_at'=>Carbon::now(),
            ]
        );
        $cart->delete();
        $placeorder = Order::where('customerId', '=', $cart->customerId)->first();
        foreach ($cartItem as $key => $item) {
            $item_id = $order_item->insertGetId(
                [
                    'orderId' => $id,
                    'productId' => $item->productId,
                    'quantity' => $item->quantity,
                    'basePrice' => $item->basePrice,
                    'price' => $item->price,
                    'discount' => $item->discount,
                ]
            );
            $item->delete();
        }
        foreach ($cartAddress as $key => $address) {
            $address_id = $order_address->insertGetId(
                [
                    'orderId' => $id,
                    'addressType' => $address->addressType,
                    'address' => $address->address,
                    'city' => $address->city,
                    'state' => $address->state,
                    'country' => $address->country,
                    'zipcode' => $address->zipcode,
                    'same_as_billing' => $address->same_as_billing,
                ]
            );
            $address->delete();
        }
        $view = view('cart.order', compact('paymentMethod', 'shippingMethod', 'customerName', 'model', 'products', 'cart', 'billingAddress', 'shippingAddress', 'cartItem'))->render();
        $response = [
            'element' => [
                [
                    'success' => 'success',
                    'name' => 'laravel',
                    'selector' => '#content',
                    'html' => $view
                ]
            ]
        ];

        header('content-type:application/json');
        echo json_encode($response);
    }
}
