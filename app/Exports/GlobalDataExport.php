<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\VendorsSheet;
use App\Exports\Sheets\QuotationsSheet;
use App\Exports\Sheets\SalesOrdersSheet;
use App\Exports\Sheets\PurchaseOrdersSheet;
use App\Exports\Sheets\ProformaInvoicesSheet;
use App\Exports\Sheets\InvoicesSheet;
use App\Exports\Sheets\CouriersSheet;
use App\Exports\Sheets\QuotationItemsSheet;
use App\Exports\Sheets\ImportedQuotationsSheet;

class GlobalDataExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        return [
            new VendorsSheet(),
            new QuotationsSheet(),
            new QuotationItemsSheet(), // Added
            new SalesOrdersSheet(),
            new PurchaseOrdersSheet(),
            new ProformaInvoicesSheet(),
            new InvoicesSheet(),
            new CouriersSheet(), // Added
            new ImportedQuotationsSheet(), // Added
        ];
    }
}
