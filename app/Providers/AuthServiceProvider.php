<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Quotation;
use App\Models\SalesOrder;
use App\Models\Vendor;
use App\Models\PurchaseOrder;
use App\Models\ProformaInvoice;
use App\Models\Invoice;
use App\Models\HsnCode;
use App\Models\DuplicateQuotation;
use App\Policies\QuotationPolicy;
use App\Policies\SalesOrderPolicy;
use App\Policies\VendorPolicy;
use App\Policies\PurchaseOrderPolicy;
use App\Policies\ProformaInvoicePolicy;
use App\Policies\InvoicePolicy;
use App\Policies\HsnCodePolicy;
use App\Policies\DuplicateQuotationPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Quotation::class, QuotationPolicy::class);
        Gate::policy(SalesOrder::class, SalesOrderPolicy::class);
        Gate::policy(Vendor::class, VendorPolicy::class);
        Gate::policy(PurchaseOrder::class, PurchaseOrderPolicy::class);
        Gate::policy(ProformaInvoice::class, ProformaInvoicePolicy::class);
        Gate::policy(Invoice::class, InvoicePolicy::class);
        Gate::policy(HsnCode::class, HsnCodePolicy::class);
        Gate::policy(DuplicateQuotation::class, DuplicateQuotationPolicy::class);
    }
}
