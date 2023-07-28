<?php

namespace App\Http\Controllers\Client;

use App\Events\OrderSuccessEvent;
use App\Http\Controllers\Controller;
use App\Http\Servies\VnpayServies;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPaymentMethod;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Redirect;


class CartController extends Controller
{
    private $vnpayService;
    public function __construct(VnpayServies $vnpayService){
        $this->vnpayService = $vnpayService;    
    }


    public function index(){
        // dd(session()->get('cart'));
        $cart = session()->get('cart') ?? [];
        return view('client.pages.shoping-cart', compact('cart'));
    }

    public function addProductToCart($productId, $qty = 1)
    {
        $product = Product::find($productId);
        if($product){
            $cart = session()->get('cart') ?? [];

            $imageLink = (is_null($product->image_url) || !file_exists('images/' . $product->image_url)) ? 'default_image.jpg' : $product->image_url;
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => number_format($product->price, 2),
                'image_url' => asset('images/'.$imageLink),
                'qty' => ($cart[$productId]['qty'] ?? 0) + $qty
            ];
            //Add cart into session
            session()->put('cart', $cart);

            $totalProduct = count($cart);
            $totalPrice = $this->calculateTotalPrice($cart);

            return response()->json(['message' => 'Add product success!', 'total_product' => $totalProduct, 'total_price'=> $totalPrice]);
        }else{
            return response()->json(['message' => 'Add product failed!'], Response::HTTP_NOT_FOUND);
        }
    }
    public function calculateTotalPrice(array $cart){
        $totalPrice = 0;
        foreach($cart as $item){
            $totalPrice += $item['qty'] * $item['price'];
        }
        return number_format($totalPrice, 2);
    }

    public function deleteProductInCart($productId){
        $cart = session()->get('cart') ?? [];
        if(array_key_exists($productId, $cart)){
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }else{
            return response()->json(['message' => 'Remove product failed!'], Response::HTTP_BAD_REQUEST);
        }
        $totalProduct = count($cart);
        $totalPrice = $this->calculateTotalPrice($cart);
        return response()->json(['message' => 'Remove success!', 'total_product' => $totalProduct, 'total_price'=> $totalPrice]);
    }


    public function updateProductInCart($productId, $qty){
        $cart = session()->get('cart') ?? [];
        if(array_key_exists($productId, $cart)){
            $cart[$productId]['qty'] = $qty;
            if(!$qty){
                unset($cart[$productId]);
            }
            session()->put('cart', $cart);
        }

        $totalProduct = count($cart);
        $totalPrice = $this->calculateTotalPrice($cart);
        return response()->json(['message' => 'Update success!', 'total_product' => $totalProduct, 'total_price'=> $totalPrice]);
    }

    public function deleteCart(){
        session()->put('cart', []);
        return response()->json(['message' => 'Delete Cart success!', 'total_product' => 0, 'total_price'=> 0]);

    }

    public function placeOrder(Request $request){
        //Validate from request
        try{
            DB::beginTransaction();

            $cart = session()->get('cart', []);
            $totalPrice = 0;
            foreach($cart as $item){
                $totalPrice += $item['qty'] * $item['price'];
            }

            //Create record order
            $order = Order::create([
                'user_id' => Auth::user()->id,
                'address' => $request->address,
                'city' => $request->city,
                'note' => $request->note,
                'payment_method' => $request->payment_method,
                'status' => Order::STATUS_PENDING,
                'subtotal' => $totalPrice,
                'total' => $totalPrice,
            ]);



            //Create record order items
            foreach($cart as $productId => $item){
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'name' => $item['name'],
                ]);
            }

            //Create recordinto table OrderPaymentMethod
            $orderPaymentMethod = OrderPaymentMethod::create([
                'order_id' => $order->id,
                'payment_provider' => $request->get('payment_method'),
                'total_balance' => $totalPrice,
                'status' => OrderPaymentMethod::STATUS_PENDING,
            ]);

            $user = User::find(Auth::user()->id);
            $user->phone = $request->phone;
            $user->save();

            //Reset session
            session()->put('cart', []);

            if(in_array($request->payment_method, ['vnpay_atm', 'vnpay_credit'])){
                // date_default_timezone_set('Asia/Ho_Chi_Minh');
                // $vnp_TxnRef = $order->id; //Mã giao dịch thanh toán tham chiếu của merchant
                // $vnp_Amount = $order->total; // Số tiền thanh toán
                // $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
                // $vnp_BankCode = 'VNBANK'; //Mã phương thức thanh toán
                // $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

                // $startTime = date("YmdHis");
                // $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));


                // $vnp_Returnurl = route('cart.callback-vnpay');
                // $inputData = array(
                //     "vnp_Version" => "2.1.0",
                //     "vnp_TmnCode" => env('VNP_TMNCODE'),
                //     "vnp_Amount" => $vnp_Amount* 100000,
                //     "vnp_Command" => "pay",
                //     "vnp_CreateDate" => date('YmdHis'),
                //     "vnp_CurrCode" => "VND",
                //     "vnp_IpAddr" => $vnp_IpAddr,
                //     "vnp_Locale" => $vnp_Locale,
                //     "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
                //     "vnp_OrderType" => "other",
                //     "vnp_ReturnUrl" => $vnp_Returnurl,
                //     "vnp_TxnRef" => $vnp_TxnRef,
                //     "vnp_ExpireDate"=>$expire
                // );

                // if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                //     $inputData['vnp_BankCode'] = $vnp_BankCode;
                // }
                // ksort($inputData);
                // $query = "";
                // $i = 0;
                // $hashdata = "";
                // foreach ($inputData as $key => $value) {
                //     if ($i == 1) {
                //         $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                //     } else {
                //         $hashdata .= urlencode($key) . "=" . urlencode($value);
                //         $i = 1;
                //     }
                //     $query .= urlencode($key) . "=" . urlencode($value) . '&';
                // }

                // $vnp_Url = env('VNP_URL') . "?" . $query;

                //     $vnpSecureHash =   hash_hmac('sha512', $hashdata, env('VNP_HASHSECRET'));//
                //     $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

                    $vnp_Url = $this->vnpayService->getVnpayUrl($order, $request->payment_method);
                return Redirect::to($vnp_Url);

            }else{
                event(new OrderSuccessEvent($order));
            }

            //Create event order success

            //Send mail to customer to confirm that order
            // Mail::to('ttruonggiangbk@gmail.com')->send(new OrderAdminEmail($order));

            //Send sms to customer

            // $receiverNumber = '+84334400700';
            // $client = new \Twilio\Rest\Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
            // $client->messages->create($receiverNumber, [
            //     'from' => env('TWILIO_PHONE_NUMBER'),
            //     'body' => 'YUP'
            // ]);


            DB::commit();
        }catch(\Exception $exception){
            DB::rollBack();
            return $exception->getMessage();
        }


        return redirect()->route('home')->with('msg', 'Order success!');
    }

    public function callBackVnPay(Request $request){
        $order = Order::find($request->vnp_TxnRef);
        if($request->vnp_ResponseCode === '00'){
            if($order){
                event(new OrderSuccessEvent($order));
            }else if($request->vnp_ResponseCode === '10'){
                if($order){
                    $order->status = 'cancel';
                    $orderPaymentMethod = $order->order_payment_methods[0];
                    $orderPaymentMethod->status = 'cancel';
                    // $orderPaymentMethod->note = 'Giao dịch không thành công do: Khách hàng xác thực thông tin thẻ/tài khoản không đúng quá 3 lần';
                }
            }
        }
    }
}

