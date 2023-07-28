<?php
namespace App\Http\Servies;
use App\Models\Order;

class VnpayServies{
    public function getVnpayUrl(Order $order, $paymentMethod):string{
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                // $vnp_TxnRef = $order->id; //Mã giao dịch thanh toán tham chiếu của merchant
                // $vnp_Amount = $order->total; // Số tiền thanh toán
                $vnp_TxnRef =(string)$order->id; //Mã giao dịch thanh toán tham chiếu của merchant
                $vnp_Amount =(string)$order->total; // Số tiền thanh toán
                $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
                $vnp_BankCode = $paymentMethod === 'vnpay_atm' ? 'VNBANK' : 'INTCART'; //Mã phương thức thanh toán
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

                $startTime = date("YmdHis");
                $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

                $vnp_Returnurl = route('cart.callback-vnpay');
                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => env('VNP_TMNCODE'),
                    "vnp_Amount" => $vnp_Amount* 100000,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
                    "vnp_OrderType" => "other",
                    "vnp_ReturnUrl" => $vnp_Returnurl,
                    "vnp_TxnRef" => $vnp_TxnRef,
                    "vnp_ExpireDate"=>$expire
                );

                if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                    $inputData['vnp_BankCode'] = $vnp_BankCode;
                }
                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }

                $vnp_Url = env('VNP_URL') . "?" . $query;

                    $vnpSecureHash =   hash_hmac('sha512', $hashdata, env('VNP_HASHSECRET'));//
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                return $vnp_Url;
    }
}


?>
