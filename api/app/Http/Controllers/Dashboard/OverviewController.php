<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Profile;
use App\Models\User;
use App\Models\Role;
use App\Models\Payment;
use App\Models\ProfileReport;
use App\Models\AdminActivity;
use App\Models\MemberActivity;
use App\Policies\OverviewPolicy;
use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Member;

class OverviewController extends Controller
{
    protected $purchaseService;
    protected $salesService;
    protected $stockBatchService;
    protected $customerService;
    protected $userService;
    protected $doctorService;
    protected $productService;
    protected $salesItemService;
    protected $purchaseInvoiceItemService;
    protected $purchaseOrderService;
    protected $purchaseOrderItemService;
    protected $purchaseInvoiceReturnItemService;
    protected $supplierService;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();

            Log::info('PRODUCT: User ID: ' . $user?->id, [
                'permissions' => $user?->permissions
            ]);

            // Initialize services without tenantId
            $this->purchaseService = new BaseService(
                new BaseRepository(new Profile())
            );

            return $next($request);
        });
    }


    public function index(Request $request)
    {
        $filters = $request->get('filters', []);

        try {
            // Authorization
            $this->authorize('viewAny', \App\Models\Overview::class);

            $monthFilter = ['created_at' => ['>=', now()->startOfMonth()]];

            // Expired stock batches
            $expired = $this->stockBatchService->list(
                ['expiry_date' => ['<', Carbon::today()->endOfDay()->toDateTimeString()]],
                with: ['product']
            );
            // Transform expired batches to include product details as flat fields
            $expired = collect($expired)->map(function ($batch) {
                return [
                    'id' => $batch->id,
                    'product_id' => $batch->product_id,
                    'batch_no' => $batch->batch_no,
                    'expiry_date' => $batch->expiry_date,
                    'quantity' => $batch->quantity,
                    'purchase_price' => $batch->purchase_price,
                    'mrp' => $batch->mrp,
                    'created_at' => $batch->created_at,
                    'updated_at' => $batch->updated_at,
                    'product_name' => $batch->product?->product_name,
                    'gst' => $batch->product?->gst,
                    'category' => $batch->product?->category,
                    'brand_name' => $batch->product?->brand_name,
                    'hsn_code' => $batch->product?->hsn_code,
                    'price' => $batch->product?->price,
                ];
            })->values()->all();

            // Prepare month-wise sales and purchase data
            $monthlyData = [];
            $year = $request->input('year', Carbon::now()->year);

            foreach (range(1, 12) as $month) {
                $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth()->toDateTimeString();
                $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth()->toDateTimeString();
                $salesCount = $this->salesService->count([
                    'created_at' => ['between', [$startOfMonth, $endOfMonth]],
                ]);

                $purchaseCount = $this->purchaseService->count([
                    'created_at' => ['between', [$startOfMonth, $endOfMonth]],
                ]);

                $monthlyData[] = [
                    'label' => Carbon::create(null, $month)->format('M'),
                    'sales' => $salesCount,
                    'purchases' => $purchaseCount,
                ];
            }

            // -------------------- Billing Status --------------------
            $totalPaid = $this->purchaseService->aggregate(
                ['SUM(amount_due) as total'],
                ['status' => 'paid']
            )[0]->total ?? 0;

            $totalUnpaid = $this->purchaseService->aggregate(
                ['SUM(amount_due) as total'],
                ['status' => 'unpaid']
            )[0]->total ?? 0;

            $totalOverdue = $this->purchaseService->aggregate(
                ['SUM(amount_due) as total'],
                ['status' => 'overdue']
            )[0]->total ?? 0;

            $totalPartiallyPaid = $this->purchaseService->aggregate(
                ['SUM(amount_due) as total'],
                ['status' => 'partial']
            )[0]->total ?? 0;


            $data = [
                // Purchases
                'total_purchases_invoices' => $this->purchaseService->count($filters),
                'total_purchases_monthly' => $this->purchaseService->count(array_merge($filters, $monthFilter)),

                // Sales
                'total_sales_invoices' => $this->salesService->count($filters),
                'total_sales_monthly' => $this->salesService->count(array_merge($filters, $monthFilter)),

                // Customers
                'total_customers' => $this->customerService->count($filters),

                // Doctors
                'total_doctors' => $this->doctorService->count($filters),

                // Products
                'total_products' => $this->productService->count($filters),

                // Suppliers
                'total_suppliers' => $this->supplierService->count($filters),

                // Sales Items
                'total_sales_items' => $this->salesItemService->count($filters),

                // Purchase Invoice Items
                'total_purchase_invoice_items' => $this->purchaseInvoiceItemService->count($filters),

                // Purchase Orders
                'total_purchase_orders' => $this->purchaseOrderService->count($filters),

                // Purchase Order Items
                'total_purchase_order_items' => $this->purchaseOrderItemService->count($filters),

                // Purchase Invoice Return Items
                'total_purchase_invoice_return_items' => $this->purchaseInvoiceReturnItemService->count($filters),

                // Users
                'total_users' => $this->userService->count($filters),

                // Stock
                'total_stock_batches' => $this->stockBatchService->count($filters),
                'expired_stock_batches' => $expired,

                // Add monthly data here
                'monthly_sales_purchases' => $monthlyData,

                // Billing Status
                'total_paid' => $totalPaid,
                'total_unpaid' => $totalUnpaid,
                'total_overdue' => $totalOverdue,
                'total_partially_paid' => $totalPartiallyPaid,
            ];

            return ApiResponse::success('Overview data fetched successfully', $data);
        } catch (\Throwable $e) {
            Log::error('Error fetching overview data', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return ApiResponse::error('Error fetching overview data', $e->getMessage());
        }
    }

    /**
     * Overview data endpoint tailored to Angular OverviewData interface.
     */
    public function overview(Request $request)
    {
        try {
            // Authorization
            $this->authorize('viewAny', \App\Models\Overview::class);

            // ---- Stats ----
            $totalMembers = Profile::count();
            $onlineMembers = User::whereNotNull('last_login_at')
                ->where('last_login_at', '>=', Carbon::now()->subDay())
                ->count();
            $blockedMembers = Member::where('blocked_by_admin', true)->count();
            $reportedMembers = ProfileReport::count();
            $incompleteProfiles = User::where('is_profile_complete', false)->count();
            $withoutProfilePictures = Profile::whereNull('profile_photo')->count();

            $offlineMembers = max(0, $totalMembers - $onlineMembers);

            $master = User::whereHas('role', fn($q) => $q->where('slug', 'super_admin'))->count();
            $accountant = User::whereHas('role', fn($q) => $q->where('slug', 'admin'))->count();
            $enabler = User::whereHas('role', fn($q) => $q->where('slug', 'staff'))->count();

            // Dynamic Roles
            $roles = Role::withCount('users')->get()->map(fn($r) => [
                'name' => $r->name,
                'slug' => $r->slug,
                'count' => $r->users_count,
            ])->values()->all();

            // Earnings
            $totalEarnings = (float) Payment::where('status', 'paid')->sum('amount');
            $onlineEarnings = (float) Payment::where('status', 'paid')->where('payment_mode', 'online')->sum('amount');
            $offlineEarnings = (float) Payment::where('status', 'paid')->where('payment_mode', 'offline')->sum('amount');

            $onlineToday = (float) Payment::where('status', 'paid')->where('payment_mode', 'online')
                ->whereDate('transaction_date', Carbon::today())
                ->sum('amount');
            $onlineLastWeek = (float) Payment::where('status', 'paid')->where('payment_mode', 'online')
                ->where('transaction_date', '>=', Carbon::now()->subWeek())
                ->sum('amount');
            $onlineLastMonth = (float) Payment::where('status', 'paid')->where('payment_mode', 'online')
                ->where('transaction_date', '>=', Carbon::now()->subMonth())
                ->sum('amount');
            $onlineLast3Months = (float) Payment::where('status', 'paid')->where('payment_mode', 'online')
                ->where('transaction_date', '>=', Carbon::now()->subMonths(3))
                ->sum('amount');
            $onlineHalfYearly = (float) Payment::where('status', 'paid')->where('payment_mode', 'online')
                ->where('transaction_date', '>=', Carbon::now()->subMonths(6))
                ->sum('amount');
            $onlineYearly = (float) Payment::where('status', 'paid')->where('payment_mode', 'online')
                ->where('transaction_date', '>=', Carbon::now()->subYear())
                ->sum('amount');

            $offlineToday = (float) Payment::where('status', 'paid')->where('payment_mode', 'offline')
                ->whereDate('transaction_date', Carbon::today())
                ->sum('amount');
            $offlineLastWeek = (float) Payment::where('status', 'paid')->where('payment_mode', 'offline')
                ->where('transaction_date', '>=', Carbon::now()->subWeek())
                ->sum('amount');
            $offlineLastMonth = (float) Payment::where('status', 'paid')->where('payment_mode', 'offline')
                ->where('transaction_date', '>=', Carbon::now()->subMonth())
                ->sum('amount');
            $offlineLast3Months = (float) Payment::where('status', 'paid')->where('payment_mode', 'offline')
                ->where('transaction_date', '>=', Carbon::now()->subMonths(3))
                ->sum('amount');
            $offlineHalfYearly = (float) Payment::where('status', 'paid')->where('payment_mode', 'offline')
                ->where('transaction_date', '>=', Carbon::now()->subMonths(6))
                ->sum('amount');
            $offlineYearly = (float) Payment::where('status', 'paid')->where('payment_mode', 'offline')
                ->where('transaction_date', '>=', Carbon::now()->subYear())
                ->sum('amount');

            $stats = [
                'totalMembers' => $totalMembers,
                'onlineMembers' => Profile::where('registration_mode', 'online')->count(),
                'offlineMembers' => Profile::where('registration_mode', 'offline')->count(),
                'blockedMembers' => $blockedMembers,
                'reportedMembers' => $reportedMembers,
                'incompleteProfiles' => $incompleteProfiles,
                'pendingprofiles' => Member::where('membership_expired', true)->where('status', 'inactive')->count(),
                'withoutprofilepictures' => $withoutProfilePictures,
                'master' => $master,
                'accountant' => $accountant,
                'enabler' => $enabler,
                'total_stories' => 0,
                'total_approved_stories' => 0,
                'total_pending_stories' => 0,
                'total_earnings' => $totalEarnings,
                'online_earnings' => $onlineEarnings,
                'offline_earnings' => $offlineEarnings,
                'online_today' => $onlineToday,
                'online_last_week' => $onlineLastWeek,
                'online_last_month' => $onlineLastMonth,
                'online_last_3_months' => $onlineLast3Months,
                'online_half_yearly' => $onlineHalfYearly,
                'online_yearly' => $onlineYearly,
                'offline_today' => $offlineToday,
                'offline_last_week' => $offlineLastWeek,
                'offline_last_month' => $offlineLastMonth,
                'offline_last_3_months' => $offlineLast3Months,
                'offline_half_yearly' => $offlineHalfYearly,
                'offline_yearly' => $offlineYearly,
            ];

            // ---- Pie Charts ----
            $pieCharts = [
                // Existing Charts

                // New Charts: Breakdown
                [
                    'title' => 'ONLINE_ACTIVE_MEMBERS',
                    'data' => [
                        'male' => Profile::where('registration_mode', 'online')
                            ->where('gender', 'male')
                            ->whereHas('member', fn($q) => $q->where('status', 'active'))
                            ->count(),
                        'female' => Profile::where('registration_mode', 'online')
                            ->where('gender', 'female')
                            ->whereHas('member', fn($q) => $q->where('status', 'active'))
                            ->count(),
                    ],
                ],
                [
                    'title' => 'ONLINE_INACTIVE_MEMBERS',
                    'data' => [
                        'male' => Profile::where('registration_mode', 'online')
                            ->where('gender', 'male')
                            ->whereHas('member', fn($q) => $q->where('status', '!=', 'active'))
                            ->count(),
                        'female' => Profile::where('registration_mode', 'online')
                            ->where('gender', 'female')
                            ->whereHas('member', fn($q) => $q->where('status', '!=', 'active'))
                            ->count(),
                    ],
                ],
                [
                    'title' => 'OFFLINE_ACTIVE_MEMBERS',
                    'data' => [
                        'male' => Profile::where('registration_mode', 'offline')
                            ->where('gender', 'male')
                            ->whereHas('member', fn($q) => $q->where('status', 'active'))
                            ->count(),
                        'female' => Profile::where('registration_mode', 'offline')
                            ->where('gender', 'female')
                            ->whereHas('member', fn($q) => $q->where('status', 'active'))
                            ->count(),
                    ],
                ],
                [
                    'title' => 'OFFLINE_INACTIVE_MEMBERS',
                    'data' => [
                        'male' => Profile::where('registration_mode', 'offline')
                            ->where('gender', 'male')
                            ->whereHas('member', fn($q) => $q->where('status', '!=', 'active'))
                            ->count(),
                        'female' => Profile::where('registration_mode', 'offline')
                            ->where('gender', 'female')
                            ->whereHas('member', fn($q) => $q->where('status', '!=', 'active'))
                            ->count(),
                    ],
                ],
                [
                    'title' => 'BLOCKED_MEMBERS',
                    'data' => [
                        'male' => Member::where('blocked_by_admin', true)->whereHas('profile', fn($q) => $q->where('gender', 'male'))->count(),
                        'female' => Member::where('blocked_by_admin', true)->whereHas('profile', fn($q) => $q->where('gender', 'female'))->count(),
                    ],
                ],
                [
                    'title' => 'INACTIVE_PROFILE_MEMBERS',
                    'data' => [
                        'male' => Profile::whereNull('profile_photo')->where('gender', 'male')->count(),
                        'female' => Profile::whereNull('profile_photo')->where('gender', 'female')->count(),
                    ],
                ],
                [
                    'title' => 'MATCHED_MEMBERS',
                    'data' => [
                        'male' => Member::where('is_matched', true)->whereHas('profile', fn($q) => $q->where('gender', 'male'))->count(),
                        'female' => Member::where('is_matched', true)->whereHas('profile', fn($q) => $q->where('gender', 'female'))->count(),
                    ],
                ],
                [
                    'title' => 'PRIME_MEMBERS',
                    'data' => [
                        'male' => Profile::where('membership_type', 'prime')->where('gender', 'male')->count(),
                        'female' => Profile::where('membership_type', 'prime')->where('gender', 'female')->count(),
                    ],
                ],
            ];

            // ---- Member Lists ----
            $maleMembers = Profile::with(['user', 'member'])
                ->where('gender', 'male')
                ->latest()
                ->take(4)
                ->get()
                ->map(fn($p) => [
                    'id' => (string) $p->id,
                    'member_no' => $p->member->member_no ?? '',
                    'name' => $p->user->name ?? 'Unknown',
                    'mobile' => $p->mobile ?? '',
                    'date' => optional($p->created_at)->format('d-m-Y H:i:s'),
                ])->values()->all();

            $femaleMembers = Profile::with(['user', 'member'])
                ->where('gender', 'female')
                ->latest()
                ->take(4)
                ->get()
                ->map(fn($p) => [
                    'id' => (string) $p->id,
                    'member_no' => $p->member->member_no ?? '',
                    'name' => $p->user->name ?? 'Unknown',
                    'mobile' => $p->mobile ?? '',
                    'date' => optional($p->created_at)->format('d-m-Y H:i:s'),
                ])->values()->all();

            // ---- Activities ----
            $memberActivities = MemberActivity::latest()
                ->take(5)
                ->get()
                ->map(fn($a) => "{$a->name} - {$a->activity_type}")
                ->values()
                ->all();

            $adminActivities = AdminActivity::latest()
                ->take(5)
                ->get()
                ->map(fn($a) => "{$a->name} - {$a->activity_type}")
                ->values()
                ->all();

            $data = [
                'stats' => $stats,
                'pieCharts' => $pieCharts,
                'maleMembers' => $maleMembers,
                'femaleMembers' => $femaleMembers,
                'memberActivities' => $memberActivities,
                'adminActivities' => $adminActivities,
                'roles' => $roles,
                'tables' => [],
            ];

            return ApiResponse::success('Overview data fetched successfully', $data);
        } catch (\Throwable $e) {
            Log::error('Error building overview data', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return ApiResponse::error('Error fetching overview data', $e->getMessage());
        }
    }
}
