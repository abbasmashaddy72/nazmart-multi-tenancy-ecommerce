<?php

namespace App\Actions\Tenant;

use App\Enums\PricePlanTypEnums;
use App\Helpers\FlashMsg;
use App\Helpers\SanitizeInput;
use App\Models\PaymentLogs;
use App\Models\PricePlan;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ReassignTenant
{
    private array $validated;
    public function __construct($validated)
    {
        $this->validated = $validated;
    }

    public function getUser()
    {
        $user_id = null;
        $payment_log = $this->getUserPaymentLog();
        if (!empty($payment_log)) // If tenant has payment log with user id
        {
            $user_id = $payment_log->user_id;
        }

        if (empty($user_id)) // If tenant does not have payment log or payment log with no user id
        {
            if (!array_key_exists('user', $this->validated)) // If user is not selected
            {
                return back()->with(FlashMsg::explain('danger', 'User field is required.'));
            }
            $user_id = (int) $this->validated['user'];
        }

        return $user_id;
    }

    public function modifyTenant(): bool
    {
        $user_id = $this->getUser();
        $theme_slug = $this->validated['custom_theme'];
        $tenant_id = $this->validated['subs_tenant_id'];
        $database_name = $this->validated['database_name'];

        $package = $this->getPackage();

        $modified = false;
        try {
            \DB::table('tenants')->where('id', $tenant_id)->update([
                'user_id' => $user_id,
                'theme_slug' => $theme_slug,
                'data' => '{"tenancy_db_name":'.json_encode(SanitizeInput::esc_html(trim($database_name))).'}',
                'start_date' => $package['package_start_date'],
                'expire_date' => $package['package_expire_date']
            ]);

            $modified = true;
        } catch (\Exception $exception) {}

        return $modified;
    }

    public function createOrModifyDatabase()
    {
        $user_id = $this->getUser();
        $user = User::find($user_id);

        $theme_slug = $this->validated['custom_theme'];
        $tenant_id = $this->validated['subs_tenant_id'];
        $payment_status = $this->validated['payment_status'];
        $account_status = $this->validated['account_status'];

        $tenantModified = $this->modifyTenant();
        if ($tenantModified)
        {
            $package = $this->getPackage();

            PaymentLogs::updateOrCreate([
                'user_id' => $user_id,
                'tenant_id' => $tenant_id
            ], [
                'email' => $user->email,
                'name' => $user->name,
                'package_name' => $package['package']->title,
                'package_price' => $package['package']->price,
                'package_gateway' => null,
                'package_id' => $package->id,
                'user_id' => $user->id,
                'tenant_id' => $tenant_id,
                'theme_slug' => $theme_slug,
                'is_renew' => 0,
                'payment_status' => $payment_status,
                'status' => $account_status,
                'track' => Str::random(10) . Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'start_date' => $package['package_start_date'],
                'expire_date' => $package['package_expire_date'],
            ]);
        }
    }

    private function getPackage(): array
    {
        $package = Cache::remember('package_plan', 60, function () {
            return PricePlan::findOrFail($this->validated['package']);
        });

        $package_start_date = '';
        $package_expire_date =  '';
        if(!empty($package)){

            if($package->type == PricePlanTypEnums::MONTHLY){ //monthly
                $package_start_date = Carbon::now()->format('d-m-Y h:i:s');
                $package_expire_date = Carbon::now()->addMonth(1)->format('d-m-Y h:i:s');

            }elseif ($package->type == PricePlanTypEnums::YEARLY){ //yearly
                $package_start_date = Carbon::now()->format('d-m-Y h:i:s');
                $package_expire_date = Carbon::now()->addYear(1)->format('d-m-Y h:i:s');
            }else{ //lifetime
                $package_start_date = Carbon::now()->format('d-m-Y h:i:s');
                $package_expire_date = null;
            }
        }

        return [
            'package' => $package,
            'package_start_date' => $package_start_date,
            'package_expire_date' => $package_expire_date
        ];
    }

    private function getUserPaymentLog()
    {
        return PaymentLogs::where('tenant_id', $this->validated['subs_tenant_id'])->latest()->first();
    }
}
