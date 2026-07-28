<?php

namespace Bits\Package\Controllers;

use Bits\Package\Repositories\InvoiceSettingRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class InvoiceSettingController extends Controller
{
    protected InvoiceSettingRepository $repo;

    public function __construct(InvoiceSettingRepository $repo)
    {
        $this->repo = $repo;
    }

    public function show(Request $request)
    {
        $settings = $this->repo->getSettings();
        return response()->json($settings);
    }

    public function update(Request $request)
    {
        $settings = $this->repo->getSettings();

        if (!$settings) {
            // Create if not exists (first time)
            $settings = $this->repo->create($request->all());
        } else {
            $settings = $this->repo->update($settings->id, $request->all());
        }

        return response()->json($settings);
    }
}
