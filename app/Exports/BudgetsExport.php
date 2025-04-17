<?php
namespace App\Exports;

use App\Models\Budget;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BudgetsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Budget::select('id','type','budget_name','category','account_id','currency_id','amount','period','year','month','carry_over','created_at')->get();
    }
    public function headings(): array
    {
        return ['ID','Type','Budget Name','Category','Account ID','Currency ID','Amount','Period','Year','Month','Carry Over','Created At'];
    }
}
