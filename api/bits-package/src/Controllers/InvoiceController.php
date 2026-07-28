<?php

namespace Bits\Package\Controllers;

use Bits\Package\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\App; // 👈 THIS WAS MISSING

class InvoiceController extends Controller
{
    protected InvoiceService $service;

    public function __construct(InvoiceService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filters = $request->all();
        $invoices = $this->service->getAllInvoices($filters);
        return response()->json($invoices);
    }

    public function show($id)
    {
        $invoice = $this->service->getInvoice($id);
        return response()->json($invoice);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date',
            'customer_id' => 'nullable', // or required, depending on rule
            'items' => 'array',
            'items.*.item_name' => 'required|string',
            'items.*.quantity' => 'required|numeric',
            'items.*.unit_price' => 'required|numeric',
            'bill_to' => 'nullable|array',
            'bill_from' => 'nullable|array',
            'customer_details' => 'nullable|array',
            'footer_text' => 'nullable|string',
            // Add other validations as needed
        ]);

        // Merge other request data not strictly validated above but safe
        $data = array_merge($request->all(), $data);

        // Ensure tenant/business context is passed (usually via middleware/auth)
        // For now, assume it's in request or handled by repo/service context

        $invoice = $this->service->createInvoice($data);
        return response()->json($invoice, 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'invoice_date' => 'date',
            'items' => 'array',
        ]);

        $data = array_merge($request->all(), $data);

        $invoice = $this->service->updateInvoice($id, $data);
        return response()->json($invoice);
    }

    public function destroy($id)
    {
        $this->service->deleteInvoice($id);
        return response()->json(['message' => 'Invoice deleted successfully']);
    }

    public function print($id)
    {
        $invoice = $this->service->getInvoice($id);
        // Load settings to pass to view
        // $settings = ...

        return view('bits::pdf.invoice', compact('invoice'));
    }

    public function downloadPdf($id)
    {
        $invoice = $this->service->getInvoice($id);

        // Placeholder for authentic PDF generation
        // if class_exists('Barryvdh\DomPDF\Facade\Pdf') ...

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('bits::pdf.invoice', compact('invoice'));
        return $pdf->download('invoice-' . $invoice->invoice_no . '.pdf');
    }
}