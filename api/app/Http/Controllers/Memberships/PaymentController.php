<?php

namespace App\Http\Controllers\Memberships;

use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Responses\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Member;
use App\Models\Membership;
use App\Models\Payment;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Razorpay\Api\Errors\SignatureVerificationError;


// class PaymentController extends Controller
// {
//     private $razorpay;
//     protected $policyModel;
//     protected $service;

//     public function __construct()
//     {
//         $this->razorpay = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
//         $this->policyModel = Payment::class;

//         $this->middleware(function ($request, $next) {
//             $authUser = Auth::user();
//             $this->service = new BaseService(
//                 new BaseRepository(new Payment(), null)
//             );

//             return $next($request);
//         });
//     }

//     // Display a list of payments
//     public function index(Request $request)
//     {
//         $this->authorize('viewAny', $this->policyModel);

//         try {
//             $payments = Payment::with(['user', 'profile', 'membership'])
//                 ->orderBy('created_at', 'desc')
//                 ->paginate(10);

//             return ApiResponse::success('Payments retrieved successfully', $payments);
//         } catch (\Throwable $e) {
//             Log::error('Failed to retrieve payments', [
//                 'error' => $e->getMessage(),
//                 'trace' => $e->getTraceAsString()
//             ]);

//             return ApiResponse::error('Failed to retrieve payments', $e->getMessage(), 500);
//         }
//     }

//     // Display a specific payment
//     public function show($id, Request $request)
//     {
//         $this->authorize('view', $this->policyModel);

//         try {
//             $payment = Payment::with(['user', 'profile', 'membership'])->findOrFail($id);

//             return ApiResponse::success('Payment retrieved successfully', $payment);
//         } catch (\Throwable $e) {
//             Log::error('Failed to retrieve payment', [
//                 'error' => $e->getMessage(),
//                 'trace' => $e->getTraceAsString()
//             ]);

//             return ApiResponse::error('Failed to retrieve payment', $e->getMessage(), 500);
//         }
//     }

//     // Step 1: Initiate Payment
//     public function initiatePayment(Request $request)
//     {
//         $this->authorize('create', $this->policyModel);

//         try {
//             $request->validate([
//                 'profile_id' => 'required|exists:profiles,id',
//                 'membership_id' => 'required|exists:memberships,id',
//             ]);

//             $profile = Profile::findOrFail($request->profile_id);
//             $membership = Membership::findOrFail($request->membership_id);

//             $orderData = [
//                 'receipt'         => 'profile_' . $profile->id . '_membership_' . $membership->id,
//                 'amount'          => $membership->price * 100, // paise
//                 'currency'        => 'INR',
//                 'payment_capture' => 1 // auto capture
//             ];

//             $razorpayOrder = $this->razorpay->order->create($orderData);



//             return ApiResponse::success('Payment initiated successfully', [
//                 'order_id' => $razorpayOrder['id'],
//                 'amount' => $membership->price,
//                 'currency' => 'INR',
//             ]);
//         } catch (\Throwable $e) {
//             Log::error('Payment Initiation Failed', [
//                 'error' => $e->getMessage(),
//                 'trace' => $e->getTraceAsString()
//             ]);

//             return ApiResponse::error('An unexpected error occurred while initiating payment.', $e->getMessage(), 500);
//         }
//     }

//     // Step 2: Verify Payment & Create Member
//     public function verifyPayment(Request $request)
//     {
//         $this->authorize('create', $this->policyModel);
//         $request->validate([
//             'profile_id' => 'required|exists:profiles,id',
//             'membership_id' => 'required|exists:memberships,id',
//             'razorpay_payment_id' => 'required|string',
//             'razorpay_order_id' => 'required|string',
//             'razorpay_signature' => 'required|string',
//         ]);

//         // Use transaction to ensure atomicity
//         DB::beginTransaction();
//         try {

//             $profile = Profile::findOrFail($request->profile_id);
//             $membership = Membership::findOrFail($request->membership_id);

//             // Verify signature
//             $generated_signature = hash_hmac(
//                 'sha256',
//                 $request->razorpay_order_id . '|' . $request->razorpay_payment_id,
//                 env('RAZORPAY_SECRET')
//             );

//             if ($generated_signature !== $request->razorpay_signature) {
//                 return ApiResponse::error('Invalid signature', 'The payment signature is invalid.', 400);
//             }

//             // Create Payment
//             $payment = Payment::create([
//                 'user_id' => $profile->user_id,
//                 'amount' => $membership->price,
//                 'payment_mode' => 'razorpay',
//                 'reference' => $request->razorpay_order_id,
//                 'transaction_date' => now(),
//                 'transaction_id' => $request->razorpay_payment_id,
//                 'status' => 'success',
//             ]);

//             // Create Member
//             $member = Member::create([
//                 'profile_id' => $profile->id,
//                 'membership_id' => $membership->id,
//                 'payment_id' => $payment->id,
//                 'start_date' => now(),
//                 'end_date' => now()->addDays($membership->duration_days),
//                 'status' => 'active',
//             ]);

//             DB::commit();

//             return ApiResponse::success('Membership activated successfully', [
//                 'member' => $member,
//                 'payment' => $payment,
//             ]);
//         } catch (\Exception $e) {
//             DB::rollBack();
//             Log::error('Member creation failed', [
//                 'error' => $e->getMessage(),
//                 'trace' => $e->getTraceAsString()
//             ]);

//             return ApiResponse::error('Member creation failed', $e->getMessage(), 500);
//         }
//     }


//     // NOT ALLOWED ACTIONS
//     public function destroy($id)
//     {
//         // NOT ALLOWED
//         return ApiResponse::error('Deletion of payments is not allowed', null, 403);
//     }

//     public function store($id)
//     {
//         // NOT ALLOWED
//         return ApiResponse::error('Creation of payments is not allowed', null, 403);
//     }

//     public function update($id)
//     {
//         // NOT ALLOWED
//         return ApiResponse::error('Updating payments is not allowed', null, 403);
//     }
// }


 
 
class PaymentController extends Controller
{
    protected $api;
 
    public function __construct()
    {
        $this->api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );
    }
 
    public function createOrder(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);
 
        $amountInPaise = intval(round($request->amount * 100));
 
        $orderData = [
            'receipt' => 'rcpt_' . uniqid(),
            'amount' => $amountInPaise,
            'currency' => 'INR',
            'payment_capture' => 1
        ];
 
        try {
            $razorpayOrder = $this->api->order->create($orderData);
 
            return response()->json([
                'success' => true,
                'order' => [
                    'id' => $razorpayOrder['id'],
                    'amount' => $razorpayOrder['amount'],
                    'currency' => $razorpayOrder['currency']
                ],
                'key' => config('services.razorpay.key')
            ]);
        } catch (\Exception $e) {
            Log::error('Razorpay createOrder error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Could not create order',
                'error' => $e->getMessage()
            ], 500);
        }
    }
 
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'razorpay_order_id' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);
 
        $attributes = $request->only([
            'razorpay_order_id',
            'razorpay_payment_id',
            'razorpay_signature',
        ]);
 
        try {
            $this->api->utility->verifyPaymentSignature($attributes);
            return response()->json(['success' => true, 'message' => 'Payment verified']);
        } catch (SignatureVerificationError $e) {
            Log::warning('Razorpay signature verification failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Invalid signature'], 400);
        } catch (\Exception $e) {
            Log::error('Razorpay verify error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Verification failed', 'error' => $e->getMessage()], 500);
        }
    }
 
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature');
 
        $webhookSecret = env('RAZORPAY_WEBHOOK_SECRET');
 
        if (!hash_equals(hash_hmac('sha256', $payload, $webhookSecret), $signature)) {
            Log::warning('Razorpay webhook signature mismatch.');
            return response()->json(['success' => false], 400);
        }
 
        $event = $request->input('event');
        $data = $request->input('payload');
 
        Log::info('Razorpay webhook event: ' . $event);
 
        return response()->json(['success' => true]);
    }
}