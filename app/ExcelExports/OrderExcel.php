<?php

namespace App\ExcelExports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;

class OrderExcel implements FromView
{
    use Exportable;

    public function forData($data) {
        $this->data = $data;

        return $this;
    }

    public function view(): View
    {
        $data = $this->data;

        return view('reports.exports.order_export', compact('data'));
    }
}
