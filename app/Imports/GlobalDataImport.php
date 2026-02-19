<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Imports\Sheets\VendorsImport;
use App\Imports\Sheets\QuotationsImport;
use App\Imports\Sheets\SalesOrdersImport;
use App\Imports\Sheets\PurchaseOrdersImport;
use App\Imports\Sheets\ProformaInvoicesImport;
use App\Imports\Sheets\InvoicesImport;
use App\Imports\Sheets\CouriersImport;
use App\Imports\Sheets\QuotationItemsImport;
use App\Imports\Sheets\ImportedQuotationsImport;

class GlobalDataImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Vendors' => new VendorsImport(),
            'Quotations' => new QuotationsImport(),
            'Quotation Items' => new QuotationItemsImport(),
            'Sales Orders' => new SalesOrdersImport(),
            'Purchase Orders' => new PurchaseOrdersImport(),
            'Proforma Invoices' => new ProformaInvoicesImport(),
            'Invoices' => new InvoicesImport(),
            'Couriers' => new CouriersImport(),
            'Imported Quotations' => new ImportedQuotationsImport(),
        ];
    }
}
