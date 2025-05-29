<?php
namespace App\ExcelImports;

use App\Model\Admin\Order;
use App\Model\Admin\OrderDetail;
use App\Model\Admin\Product;
use DateTime;
use Carbon\Carbon;
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
            if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3]) || empty($row[4])) {
                $this->skip_rows++;
                continue;
            }
            $code = trim($row[0]);
            $order_at = trim($row[1]);
            $product_name = trim($row[2]);
            $total_price = trim($row[3]);
            $total_revenue = trim($row[4]);
            $status = 30;
            $merchant = 'shopee';
            $comment = null;

            // if ($status == 'Pending') {
            //     $status = 10;
            // } else if ($status == 'Pre approved') {
            //     $status = 20;
            // } else if ($status == 'Approved') {
            //     $status = 30;
            // } else if ($status == 'Rejected') {
            //     $status = 40;
            // }

            // if(count($errors)) {
            //     $this->invalid_rows[] = [
            //         'detail' => implode("\n", $errors),
            //         'row' => $row,
            //         'index' => $index + 2,
            //     ];
            //     $this->skip_rows++;
            //     continue;
            // }
            $order = Order::query()->with('details')->where('code', $code)->first();
            $product = Product::where('name', $product_name)->first();

            if($order && $order->created_at->greaterThan(Carbon::now()->subMinutes(2))) {
                $order->total_before_discount += $total_price;
                $order->total_after_discount += $total_price;
                $order->aff_total_revenue += $total_revenue;
                $order->comment = $comment ?? null;
                $order->save();
                $order_details = OrderDetail::where('order_id', $order->id)->where('product_name', $product_name)->first();
                if(!$order_details) {
                    $order_detail = new OrderDetail();
                    $order_detail->order_id = $order->id;
                    $order_detail->product_id = $product ? $product->id : null;
                    $order_detail->product_name = $product_name;
                    $order_detail->price = $total_price;
                    $order_detail->aff_revenue = $total_revenue;
                    $order_detail->save();
                } else {
                    $order_details->price += $total_price;
                    $order_details->aff_revenue += $total_revenue;
                    $order_details->save();
                }
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
                $order->aff_order_at = Carbon::createFromFormat('d/m/Y H:i:s', $order_at)->format('Y-m-d H:i:s');
                $order->save();

                $order_detail = new OrderDetail();
                $order_detail->order_id = $order->id;
                $order_detail->product_id = $product ? $product->id : null;
                $order_detail->product_name = $product_name;
                $order_detail->price = $total_price;
                $order_detail->aff_revenue = $total_revenue;
                $order_detail->save();
            }
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
