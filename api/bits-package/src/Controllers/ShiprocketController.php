<?php
namespace Bits\Shipping\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Bits\Shipping\Services\ShiprocketService;

class ShiprocketController extends Controller
{
    public function __construct(
        protected ShiprocketService $shiprocket
    ) {}

    public function track(string $awb)
    {
        return $this->shiprocket->track($awb);
    }
}