<?php
namespace Bits\Shipping\Events;

class ShippingCreateRequested
{
    public function __construct(
        public int $orderId
    ) {}
}namespace App\Listeners;

use Bits\Shipping\Events\ShippingCreateRequested;
use Bits\Shipping\Services\ShiprocketService;
use App\Models\Order;
use App\Models\Shipping;

class CreateShiprocketOrder
{
    public function __construct(
        protected ShiprocketService $shiprocket
    ) {}
    }
    // public function handle(ShippingCreateRequested $event)
    // {
    //     $order = Order::with(['user', 'address', 'orderItems.product'])
    //         ->findOrFail($event->orderId);

    //     $payload = [
    //         "order_id" => $order->order_number,
    //         "order_date" => now()->format('Y-m-d H:i:s'),
    //         "pickup_location" => config('services.shiprocket.pickup'),
    //         "channel_id" => (int) config('services.shiprocket.channel_id'),

    //         "billing_customer_name" => $order->user->firstname,
    //         "billing_last_name" => $order->user->lastname ?? '',
    //         "billing_address" => $order->address->street,
    //         "billing_city" => $order->address->city,
    //         "billing_pincode" => $order->address->postal_code,
    //         "billing_state" => $order->address->state,
    //         "billing_country" => "India",
    //         "billing_email" => $order->user->email,
    //         "billing_phone" => $order->user->phone,

    //         "shipping_is_billing" => true,

    //         "order_items" => $order->orderItems->map(fn ($item) => [
    //             "name" => $item->product->name,
    //             "sku" => $item->product->sku,
    //             "units" => $item->quantity,
    //             "selling_price" => $item->unit_price,
    //             "hsn" => 441122,
    //         ])->toArray(),

    //         "payment_method" => $order->payment_method === 'cod' ? 'COD' : 'Prepaid',
    //         "sub_total" => $order->total_price,
    //         "length" => 10,
    //         "breadth" => 15,
    //         "height" => 20,
    //         "weight" => max(0.1, $order->total_weight),
    //     ];

    //     $data = $this->shiprocket->createOrder($payload);

    //     Shipping::updateOrCreate(
    //         ['order_id' => $order->id],
    //         [
    //             'provider' => 'shiprocket',
    //             'shipment_id' => $data['shipment_id'] ?? null,
    //             'awb' => $data['awb_code'] ?? null,
    //             'courier_name' => $data['courier_name'] ?? null,
    //             'status' => 'created',
    //         ]
    //     );
    // } main app code