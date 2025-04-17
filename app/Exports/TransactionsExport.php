<?php
namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Transaction::select('id','account_id','type','amount','category','description','date','created_at')->get();
    }
    public function headings(): array
    {
        return ['ID','Account ID','Type','Amount','Category','Description','Date','Created At'];
    }
}
