<?php

namespace Bits\Package\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DocsController extends Controller
{
    public function index(Request $request)
    {
        $docs = [
            'title' => 'BaseRepository Documentation',
            'description' => 'Reusable Laravel repository for CRUD, filters, joins, and aggregation with tenant support.',
            'methods' => [
                'all' => [
                    'description' => 'Fetch all records with optional filters, joins, relations, and order.',
                    'params' => ['filters', 'joins', 'with', 'orderBy'],
                    'examples' => [
                        'simple: GET all customers with sales invoices and active status and involved customer data' => '
                         
                         $with = ["customer"];
                         $joins = [
                             ["customers as c", "c.id", "=", "sales_invoices.customer_id"]
                         ];
                         $filter = ["status" => "active"];
                         $repo->all($filter, $with, $joins);',
                        'complex' => '$repo->all([["created_at", ">=", now()->subDays(30)]], [], ["customer"]);'
                    ],
                ],
                'find' => [
                    'description' => 'Find record by ID or filters.',
                    'examples' => [
                        'by_id' => '$repo->find(1);',
                        'by_filters' => '$repo->find(["email" => "john@example.com"]);'
                    ],
                ],
                'create' => [
                    'description' => 'Create a new record with tenant auto-fill.',
                    'example' => '$repo->create(["name" => "John"]);'
                ],
                'update' => [
                    'description' => 'Update a record by ID.',
                    'example' => '$repo->update(1, ["name" => "Updated"]);'
                ],
                'delete' => [
                    'description' => 'Delete a record by ID.',
                    'example' => '$repo->delete(1);'
                ],
                'bulkInsert' => [
                    'description' => 'Insert multiple records with timestamps.',
                    'example' => '$repo->bulkInsert([["name" => "A"], ["name" => "B"]]);'
                ],
                'count' => [
                    'description' => 'Get total count using filters.',
                    'example' => '$repo->count(["status" => "active"]);'
                ],
                'sum' => [
                    'description' => 'Sum a column with filters.',
                    'example' => '$repo->sum("amount", ["status" => "paid"]);'
                ],
                'aggregate' => [
                    'description' => 'Run grouped aggregate queries (SUM, COUNT, etc.).',
                    'example' => '$repo->aggregate(["MONTH(created_at) as month", "SUM(total) as total"], [["status", "=", "paid"]], ["month"]);'
                ],
            ],
            'filters' => [
                'formats' => [
                    'simple' => ['status' => 'active'],
                    'operator' => ['amount' => ['>', 1000]],
                    'array_of_arrays' => [['created_at', '>=', '2025-10-01']]
                ],
            ],
            'joins' => [
                'example' => [
                    ['customers as c', 'c.id', '=', 'sales_invoices.customer_id']
                ],
            ],
            'with' => [
                'example' => ['customer', 'items.product'],
            ],
            'orderBy' => [
                'example' => ['created_at' => 'desc']
            ]
        ];

        // Return JSON if requested
        if ($request->wantsJson()) {
            return response()->json($docs);
        }

        // Otherwise, return Blade view from package
        return view('bits-package::docs.repository', compact('docs'));
    }
}