<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\ModelEventObserver;
use App\Models\Quotation;
use App\Models\SalesOrder;
use App\Models\Invoice;
use App\Models\ProformaInvoice;
use App\Models\Vendor;
use App\Models\PurchaseOrder;
use App\Models\HsnCode;
use App\Models\DuplicateQuotation;

class AppServiceProvider extends ServiceProvider
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
        // Register model observers for audit logging
        $observer = new ModelEventObserver();
        Quotation::observe($observer);
        SalesOrder::observe($observer);
        Invoice::observe($observer);
        ProformaInvoice::observe($observer);
        Vendor::observe($observer);
        PurchaseOrder::observe($observer);
        HsnCode::observe($observer);
        DuplicateQuotation::observe($observer);
    }
}
