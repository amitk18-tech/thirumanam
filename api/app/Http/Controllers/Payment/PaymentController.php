<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Membership;
use App\Models\Payment;
use Bits\Package\Controllers\BaseController;
use Razorpay\Api\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Bits\Package\Responses\ApiResponse;
use Illuminate\Support\Facades\Log;
use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;


class PaymentController extends BaseController
{
    public function __construct()
    {
        $this->policyModel = Payment::class;

        $this->middleware(function ($request, $next) {
            $authUser = Auth::user();

            Log::info('MEMBERSHIP: Authenticated User', [
                'role' => $authUser?->role,
                'permissions' => $authUser?->permissions ?? [],
            ]);

            // No tenant_id in memberships → pass null
            $this->service = new BaseService(
                new BaseRepository(new Payment(), null)
            );

            return $next($request);
        });

    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'membership_id' => 'required|exists:memberships,id',
        ]);

        $membership = Membership::findOrFail($request->membership_id);

        // 🔐 Prevent free plan payment
        if ($membership->price <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid paid plan'
            ], 400);
        }

        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        $order = $api->order->create([
            'receipt' => 'rcpt_' . uniqid(),
            'amount' => $membership->price * 100, // paise
            'currency' => 'INR',
        ]);

        DB::table('payments')->insert([
            'profile_id' => Auth::user()->profile->id, // ✅ FIXED
            'membership_id' => $membership->id,
            'razorpay_order_id' => $order['id'],
            'amount' => $membership->price,
            'status' => 'created',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'order' => [
                    'id' => $order['id'],
                    'amount' => $order['amount'],
                    'currency' => $order['currency'],
                ],
                'key' => config('services.razorpay.key'),
            ]
        ]);
    }


    public function verify(Request $request)
    {
        $request->validate([
            'razorpay_order_id' => 'required',
            'razorpay_payment_id' => 'required',
            'razorpay_signature' => 'required',
            'membership_id' => 'required|exists:memberships,id',
        ]);

        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        // 1️⃣ Verify Razorpay signature
        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Signature verification failed'
            ], 400);
        }

        DB::beginTransaction();

        try {
            $profileId = Auth::user()->profile->id;

            // 2️⃣ Fetch payment & OWNERSHIP CHECK
            $payment = DB::table('payments')
                ->where('razorpay_order_id', $request->razorpay_order_id)
                ->where('profile_id', $profileId)
                ->lockForUpdate()
                ->first();

            if (!$payment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid payment request'
                ], 403);
            }

            // 3️⃣ Prevent double verification
            if ($payment->status === 'paid') {
                return response()->json([
                    'success' => true,
                    'message' => 'Payment already processed'
                ]);
            }

            // 4️⃣ Update payment
            DB::table('payments')
                ->where('id', $payment->id)
                ->update([
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature,
                    'status' => 'paid',
                    'updated_at' => now(),
                ]);

            // 5️⃣ Get member
            $member = Member::with('profile')
                ->where('profile_id', $profileId)
                ->latest()
                ->firstOrFail();

            // 6️⃣ Membership
            $membership = Membership::findOrFail($request->membership_id);

            /*
        |--------------------------------------------------------------------------
        | 🔥 TEMPORARY vs REAL MEMBER
        |--------------------------------------------------------------------------
        */
            if ($member->member_no === 'Temporary') {

                // TEMP → UPDATE
                $member->update([
                    'membership_id' => $membership->id,
                    'start_date' => now(),
                    'end_date' => now()->addDays($membership->duration_days),
                    'status' => 'active',
                    'member_no' => $this->generateMemberNo($member),
                    'profiles_view_allowed' => $membership->profiles_view_allowed ?? 0,
                    'profiles_view_remaining' => $membership->profiles_view_allowed ?? 0,
                    'sent_interest_allowed' => $membership->sent_interest_allowed ?? 0,
                    'sent_interest_remaining' => $membership->sent_interest_allowed ?? 0,
                    'messages_sent_allowed' => $membership->messages_sent_allowed ?? 0,
                    'messages_sent_remaining' => $membership->messages_sent_allowed ?? 0,
                    'phone_numbers_allowed' => $membership->phone_numbers_allowed ?? 0,
                    'phone_numbers_remaining' => $membership->phone_numbers_allowed ?? 0,
                ]);
            } else {

                // REAL → EXPIRE + NEW
                $member->update(['status' => 'expired']);

                $newMember = Member::create([
                    'profile_id' => $profileId,
                    'membership_id' => $membership->id,
                    'start_date' => now(), 
                    'end_date' => now()->addDays($membership->duration_days),
                    'status' => 'active',

                    'profiles_view_allowed' => $membership->profiles_view_allowed ?? 0,
                    'profiles_view_remaining' => $membership->profiles_view_allowed ?? 0,
                    'sent_interest_allowed' => $membership->sent_interest_allowed ?? 0,
                    'sent_interest_remaining' => $membership->sent_interest_allowed ?? 0,
                    'messages_sent_allowed' => $membership->messages_sent_allowed ?? 0,
                    'messages_sent_remaining' => $membership->messages_sent_allowed ?? 0,
                    'phone_numbers_allowed' => $membership->phone_numbers_allowed ?? 0,
                    'phone_numbers_remaining' => $membership->phone_numbers_allowed ?? 0,
                ]);

                $newMember->member_no = $this->generateMemberNo($newMember);
                $newMember->save();
            }

            DB::commit();

            return response()->json([
                'data' => [
                    'success' => true,
                    'status' => 'paid',
                    'message' => 'Payment verified'
                ]
            ]);
        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'data' => [
                    'success' => false,
                    'status' => 'failed',
                    'message' => 'Payment verification failed',
                    'error' => $e->getMessage()
                ]
            ], 500);
        }
    }


    /**
     * Generate Member Number
     */
    private function generateMemberNo(Member $member): string
    {
        $gender = strtolower($member->profile->gender); // male / female
        $prefix = ucfirst($gender); // Male / Female

        DB::beginTransaction();

        try {

            /* 🔥 gender-wise highest prefix_id */
            $lastPrefix = Member::whereHas('profile', function ($q) use ($gender) {
                $q->where('gender', $gender);
            })
                ->whereNotNull('prefix_id')
                ->lockForUpdate()
                ->max('prefix_id');

            $lastPrefix = (int) $lastPrefix;

            // First member start value
            if ($lastPrefix === 0) {
                $nextPrefix = $gender === 'male' ? 1000 : 5000;
            } else {
                $nextPrefix = $lastPrefix + 1;
            }

            /* 🔥 SAVE */
            $member->prefix_id = $nextPrefix;
            $member->member_no = $prefix . $nextPrefix;
            $member->save();

            DB::commit();

            return $member->member_no;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', Payment::class);

            $data = $this->service->list(
                $request->get('filters', []),
                $request->get('joins', []),
                $request->get('with', [])
            );

            return ApiResponse::success('Fetched successfully', $data);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to fetch', $e->getMessage(), 500);
        }
    }

}