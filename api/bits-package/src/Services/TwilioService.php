<?php

namespace Bits\Package\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(
            config('twilio.sid'),
            config('twilio.auth_token')
        );
    }

    /**
     * Send WhatsApp Template Message
     */
    public function sendWhatsAppTemplate(string $mobile, string $contentSid, array $variables = [])
    {
        $from = config('twilio.whatsapp_from');
        $to   = 'whatsapp:' . $mobile;

        $message = $this->twilio->messages->create($to, [
            "from"             => $from,
            "contentSid"       => $contentSid,
            "contentVariables" => empty($variables) ? "{}" : json_encode($variables)
        ]);

        return $message;
    }

    /**
     * Send SMS OTP
     */
    public function sendSmsOtp(string $mobile, string $otp)
    {
        $from = config('twilio.sms_from');
        $to   = $mobile;

        $message = $this->twilio->messages->create($to, [
            "from" => $from,
            "body" => "Your OTP is: {$otp}"
        ]);

        return $message;
    }
}