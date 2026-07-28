<?php

namespace Bits\Package\Services\HotelManagement;

use App\Models\SpaceBooking;

class CancellationPolicyService
{
    public function calculateRefund(SpaceBooking $booking): float
    {
        // ✅ CAST to float (IMPORTANT)
        $paid = (float) $booking->advance_amount;

        if ($paid <= 0) {
            return 0.0;
        }

        $hoursBeforeCheckIn = now()->diffInHours($booking->check_in);

        // 🔹 Hotel-specific policy (APP config)
        $hotelPolicy = config('hotel-cancellation.hotels.' . $booking->hotel_id);

        if ($hotelPolicy) {
            return $this->applyPolicy($hotelPolicy, $paid, $hoursBeforeCheckIn);
        }

        // 🔹 Default policy (PACKAGE config)
        $defaultPolicy = config('hotel-cancellation.default');

        return $this->applyPolicy($defaultPolicy, $paid, $hoursBeforeCheckIn);
    }

    private function applyPolicy(array $policies, float $paid, int $hours): float
    {
        foreach ($policies as $policy) {
            if ($hours >= $policy['hours']) {
                return round(
                    $paid * ($policy['refund_percent'] / 100),
                    2
                );
            }
        }

        return 0.0;
    }
}
