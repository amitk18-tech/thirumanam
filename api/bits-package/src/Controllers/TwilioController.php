<?php

namespace Bits\Package\Controllers;

use Illuminate\Http\Request;
use Bits\Package\Services\TwilioService;
use Bits\Package\Responses\ApiResponse;



class TwilioController extends Controller
{
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    public function sendWhatsAppOtp(Request $request)
    {
        $request->validate([
            'mobile'     => 'required|string',
            'contentSid' => 'required|string',
            'otp'        => 'nullable|string'
        ]);

        try {
            $variables = [];
            if ($request->otp) {
                $variables["1"] = $request->otp; // matches {{1}} in template
            }

            $message = $this->twilioService->sendWhatsAppTemplate(
                $request->mobile,
                $request->contentSid,
                $variables
            );

            return ApiResponse::success([
                'message' => 'WhatsApp template message sent successfully!',
                'sid'     => $message->sid
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage()
            ]);
        }
    }

    public function sendSmsOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|string',
            'otp'    => 'required|string'
        ]);

        try {
            $message = $this->twilioService->sendSmsOtp(
                $request->mobile,
                $request->otp
            );

            return ApiResponse::success([
                'message' => 'SMS OTP sent successfully!',
                'sid'     => $message->sid
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage()
            ]);
        }
    }
}