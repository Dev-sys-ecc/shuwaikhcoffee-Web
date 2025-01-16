namespace App\Http\Controllers\product;

use Illuminate\Http\Request;

class KnetController extends Controller
{

    public function processPayment()
    {
        $amount = 1;
        $trackId = uniqid();

        // قم بتكوين البيانات لإرسالها إلى بوابة KNET
        $data = [
            'id' => env('KNET_TRANSPORTAL_ID'),
            'password' => env('KNET_TRANSPORTAL_PASSWORD'),
            'action' => env('KNET_ACTION'),
            'amt' => $amount,
            'trackid' => $trackId,
            'currencycode' => 414, // كود العملة الكويتية
            'langid' => 'AR', // أو 'AR' للغة العربية
            'responseURL' => route('paymentResponse'),
            'errorURL' => route('paymentError')
        ];

        // تكوين الطلب وإرساله إلى بوابة KNET
        $query = http_build_query($data);
        $url = env('KNET_ACTION') . '?' . $query;

        return redirect()->away($url);
    }

    public function paymentResponse(Request $request)
    {
        // معالجة الاستجابة من KNET
        $transactionStatus = $request->input('result');

        if ($transactionStatus == 'CAPTURED') {
            // معالجة المعاملة الناجحة
        } else {
            // معالجة المعاملة الفاشلة
        }
    }

    public function paymentError()
    {
        // معالجة خطأ الدفع
    }
}
