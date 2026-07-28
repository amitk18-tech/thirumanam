<?php

namespace App\Providers;

use App\Models\FamilyDetail;
use App\Models\Profile;
use App\Policies\ProfilePolicy;
use App\Policies\FamilyDetailPolicy;
use App\Models\PartnerPreference;
use App\Policies\PartnerPreferencePolicy;
use App\Models\MatchAction;
use App\Models\Membership;
use App\Models\Permission;
use App\Policies\MatchActionPolicy;
use App\Policies\MembershipPolicy;
use App\Models\Photo;
use App\Policies\PhotoPolicy;
use App\Models\RolePermission;
use App\Policies\RolePermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\PermissionPolicy;
use App\Models\Role;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Policies\MemberActivityPolicy;
use App\Models\MemberActivity;
use App\Policies\AdminActivityPolicy;
use App\Models\AdminActivity;
use App\Models\Member;
use App\Policies\MemberPolicy;
use App\Policies\HoroscopePolicy;
use App\Models\HoroscopeBox;
use App\Models\Overview;
use App\Policies\OverviewPolicy;
use App\Models\Payment;
use App\Policies\PaymentPolicy;



// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [

        Profile::class => ProfilePolicy::class,
        FamilyDetail::class => FamilyDetailPolicy::class,
        PartnerPreference::class => PartnerPreferencePolicy::class,
        MatchAction::class => MatchActionPolicy::class,
        Membership::class => MembershipPolicy::class,
        Photo::class => PhotoPolicy::class,
        RolePermission::class => RolePermissionPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        User::class => UserPolicy::class,
        MemberActivity::class => MemberActivityPolicy::class,
        AdminActivity::class => AdminActivityPolicy::class,
        Member::class => MemberPolicy::class,
        HoroscopeBox::class => HoroscopePolicy::class,
        Overview::class => OverviewPolicy::class,
        Payment::class => PaymentPolicy::class,
        // Add other model-policy mappings here as needed

    ];


    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        $this->registerPolicies();
    }
}