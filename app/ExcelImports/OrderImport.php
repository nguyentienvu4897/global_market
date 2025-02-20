<?php
namespace App\ExcelImports;

use App\Model\Admin\Order;
use DateTime;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class OrderImport implements ToCollection, WithStartRow, WithMultipleSheets
{
    private $import_rows = 0;
    private $skip_rows = 0;
    private $invalid_rows = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row)
        {
            $errors = [];
            if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[5]) || empty($row[7])) {
                $this->skip_rows++;
                continue;
            }
            $order_at = trim($row[0]);
            $code = trim($row[1]);
            $status = trim($row[2]);
            $total_price = trim($row[5]);
            $total_revenue = trim($row[6]);
            $merchant = trim($row[7]);
            $comment = trim($row[9]);

            if ($status == 'Pending') {
                $status = 10;
            } else if ($status == 'Pre approved') {
                $status = 20;
            } else if ($status == 'Approved') {
                $status = 30;
            } else if ($status == 'Rejected') {
                $status = 40;
            }

            // if(count($errors)) {
            //     $this->invalid_rows[] = [
            //         'detail' => implode("\n", $errors),
            //         'row' => $row,
            //         'index' => $index + 2,
            //     ];
            //     $this->skip_rows++;
            //     continue;
            // }
            $order = Order::where('code', $code)->first();
            if($order) {
                $order->status = $status;
                $order->total_before_discount = $total_price;
                $order->total_after_discount = $total_price;
                $order->aff_total_revenue = $total_revenue;
                $order->comment = $comment ?? null;
            } else {
                $order = new Order();
                $order->customer_name = $merchant;
                $order->customer_phone = $merchant;
                $order->status = $status;
                $order->type = 1;
                $order->code = $code;
                $order->total_before_discount = $total_price;
                $order->total_after_discount = $total_price;
                $order->aff_total_revenue = $total_revenue;
                $order->aff_merchant = $merchant;
                $order->comment = $comment ?? null;
                $order->aff_order_at = $order_at;
            }
            $order->save();
            $this->import_rows++;
        }
    }

    public function startRow(): int
    {
        return 2;
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }

    public function getImportCount(): int
    {
        return $this->import_rows;
    }

    public function getSkipCount(): int
    {
        return $this->skip_rows;
    }

    public function getInvalidRow()
    {
        return $this->invalid_rows;
    }
}
