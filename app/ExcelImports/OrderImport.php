<?php
namespace App\ExcelImports;

use App\Model\Admin\Order;
use App\Model\Admin\OrderDetail;
use App\Model\Admin\OrderRevenueDetail;
use App\Model\Admin\Product;
use App\Model\Common\User;
use DateTime;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Auth;

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
            if (empty($row[0]) || empty($row[1]) || empty($row[2])) {
                $this->skip_rows++;
                continue;
            }
            $code = trim($row[0]);
            $order_at = trim($row[1]);
            if (is_numeric($order_at)) {
                $order_at = Carbon::instance(Date::excelToDateTimeObject($order_at));
                $order_at = $order_at->format('d/m/Y H:i:s');
            }
            $product_name = trim($row[2]);
            $total_price = trim($row[3]);
            $total_revenue = trim($row[4]);
            $sub_id1 = trim($row[5]);
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
            if($order && !$order->created_at->greaterThan(Carbon::now()->subMinutes(2))) {
                $this->skip_rows++;
                continue;
            }

            $current_user = User::query()->with([
                'parent' => function ($q) {
                    $q->with([
                        'parent' => function ($q) {
                            $q->with([
                                'parent' => function ($q) {
                                    $q->with([
                                        'parent' => function ($q) {
                                            $q->where('status', 1)->whereIn('type', [10, 20, 30]);
                                        }
                                    ])->where('status', 1)->whereIn('type', [10, 20, 30]);
                                }
                            ])->where('status', 1)->whereIn('type', [10, 20, 30]);
                        }
                    ])->where('status', 1)->whereIn('type', [10, 20, 30]);
                }
            ])->where('invite_code', $sub_id1)->where('status', 1)->whereIn('type', [10, 20, 30])->first();
            $config = \App\Model\Admin\Config::where('id', 1)->select('revenue_percent_1', 'revenue_percent_2', 'revenue_percent_3', 'revenue_percent_4', 'revenue_percent_5')->first();

            if($order && $order->created_at->greaterThan(Carbon::now()->subMinutes(2))) {
                $order->total_before_discount += $total_price;
                $order->total_after_discount += $total_price;
                $order->aff_total_revenue += $total_revenue;
                $order->comment = $comment ?? null;
                $order->updated_by = Auth::guard('admin')->user()->id;
                $order->save();
                if(isset($current_user)) {
                    $order->customer_name = $current_user->name;
                    $order->customer_email = $current_user->email;
                    $order->customer_phone = $current_user->phone_number;
                    $order->save();

                    $revenue_amount_level_1 = $total_revenue * $config->revenue_percent_1 / 100;
                    $revenue_amount_level_2 = $total_revenue * $config->revenue_percent_2 / 100;
                    $revenue_amount_level_3 = $total_revenue * $config->revenue_percent_3 / 100;
                    $revenue_amount_level_4 = $total_revenue * $config->revenue_percent_4 / 100;
                    $revenue_amount_level_5 = $total_revenue * $config->revenue_percent_5 / 100;

                    $order_revenue_detail = new OrderRevenueDetail();
                    $order_revenue_detail->order_id = $order->id;
                    $order_revenue_detail->order_code = $order->code;
                    $order_revenue_detail->user_id = $current_user->id;
                    $order_revenue_detail->user_email = $current_user->email;
                    $order_revenue_detail->user_level = 5;
                    $order_revenue_detail->status = OrderRevenueDetail::STATUS_WAIT_QUYET_TOAN;
                    $order_revenue_detail->revenue_amount = $revenue_amount_level_5;
                    $order_revenue_detail->save();

                    if (isset($current_user->parent)) {
                        $order_revenue_detail = new OrderRevenueDetail();
                        $order_revenue_detail->order_id = $order->id;
                        $order_revenue_detail->order_code = $order->code;
                        $order_revenue_detail->user_id = $current_user->parent->id;
                        $order_revenue_detail->user_email = $current_user->parent->email;
                        $order_revenue_detail->user_level = 4;
                        $order_revenue_detail->status = OrderRevenueDetail::STATUS_WAIT_QUYET_TOAN;
                        $order_revenue_detail->revenue_amount = $revenue_amount_level_4;
                        $order_revenue_detail->save();
                    }

                    if (isset($current_user->parent) && isset($current_user->parent->parent)) {
                        $order_revenue_detail = new OrderRevenueDetail();
                        $order_revenue_detail->order_id = $order->id;
                        $order_revenue_detail->order_code = $order->code;
                        $order_revenue_detail->user_id = $current_user->parent->parent->id;
                        $order_revenue_detail->user_email = $current_user->parent->parent->email;
                        $order_revenue_detail->user_level = 3;
                        $order_revenue_detail->status = OrderRevenueDetail::STATUS_WAIT_QUYET_TOAN;
                        $order_revenue_detail->revenue_amount = $revenue_amount_level_3;
                        $order_revenue_detail->save();
                    }

                    if (isset($current_user->parent) && isset($current_user->parent->parent) && isset($current_user->parent->parent->parent)) {
                        $order_revenue_detail = new OrderRevenueDetail();
                        $order_revenue_detail->order_id = $order->id;
                        $order_revenue_detail->order_code = $order->code;
                        $order_revenue_detail->user_id = $current_user->parent->parent->parent->id;
                        $order_revenue_detail->user_email = $current_user->parent->parent->parent->email;
                        $order_revenue_detail->user_level = 2;
                        $order_revenue_detail->status = OrderRevenueDetail::STATUS_WAIT_QUYET_TOAN;
                        $order_revenue_detail->revenue_amount = $revenue_amount_level_2;
                        $order_revenue_detail->save();
                    }

                    if (isset($current_user->parent) && isset($current_user->parent->parent) && isset($current_user->parent->parent->parent) && isset($current_user->parent->parent->parent->parent)) {
                        $order_revenue_detail = new OrderRevenueDetail();
                        $order_revenue_detail->order_id = $order->id;
                        $order_revenue_detail->order_code = $order->code;
                        $order_revenue_detail->user_id = $current_user->parent->parent->parent->parent->id;
                        $order_revenue_detail->user_email = $current_user->parent->parent->parent->parent->email;
                        $order_revenue_detail->user_level = 1;
                        $order_revenue_detail->status = OrderRevenueDetail::STATUS_WAIT_QUYET_TOAN;
                        $order_revenue_detail->revenue_amount = $revenue_amount_level_1;
                        $order_revenue_detail->save();
                    }
                }
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
                $order->created_by = Auth::guard('admin')->user()->id;
                $order->updated_by = Auth::guard('admin')->user()->id;
                $order->save();

                if(isset($current_user)) {
                    $order->customer_name = $current_user->name;
                    $order->customer_email = $current_user->email;
                    $order->customer_phone = $current_user->phone_number;
                    $order->save();

                    $revenue_amount_level_1 = $total_revenue * $config->revenue_percent_1 / 100;
                    $revenue_amount_level_2 = $total_revenue * $config->revenue_percent_2 / 100;
                    $revenue_amount_level_3 = $total_revenue * $config->revenue_percent_3 / 100;
                    $revenue_amount_level_4 = $total_revenue * $config->revenue_percent_4 / 100;
                    $revenue_amount_level_5 = $total_revenue * $config->revenue_percent_5 / 100;

                    $order_revenue_detail = new OrderRevenueDetail();
                    $order_revenue_detail->order_id = $order->id;
                    $order_revenue_detail->order_code = $order->code;
                    $order_revenue_detail->user_id = $current_user->id;
                    $order_revenue_detail->user_email = $current_user->email;
                    $order_revenue_detail->user_level = 5;
                    $order_revenue_detail->status = OrderRevenueDetail::STATUS_WAIT_QUYET_TOAN;
                    $order_revenue_detail->revenue_amount = $revenue_amount_level_5;
                    $order_revenue_detail->save();

                    if (isset($current_user->parent)) {
                        $order_revenue_detail = new OrderRevenueDetail();
                        $order_revenue_detail->order_id = $order->id;
                        $order_revenue_detail->order_code = $order->code;
                        $order_revenue_detail->user_id = $current_user->parent->id;
                        $order_revenue_detail->user_email = $current_user->parent->email;
                        $order_revenue_detail->user_level = 4;
                        $order_revenue_detail->status = OrderRevenueDetail::STATUS_WAIT_QUYET_TOAN;
                        $order_revenue_detail->revenue_amount = $revenue_amount_level_4;
                        $order_revenue_detail->save();
                    }

                    if (isset($current_user->parent) && isset($current_user->parent->parent)) {
                        $order_revenue_detail = new OrderRevenueDetail();
                        $order_revenue_detail->order_id = $order->id;
                        $order_revenue_detail->order_code = $order->code;
                        $order_revenue_detail->user_id = $current_user->parent->parent->id;
                        $order_revenue_detail->user_email = $current_user->parent->parent->email;
                        $order_revenue_detail->user_level = 3;
                        $order_revenue_detail->status = OrderRevenueDetail::STATUS_WAIT_QUYET_TOAN;
                        $order_revenue_detail->revenue_amount = $revenue_amount_level_3;
                        $order_revenue_detail->save();
                    }

                    if (isset($current_user->parent) && isset($current_user->parent->parent) && isset($current_user->parent->parent->parent)) {
                        $order_revenue_detail = new OrderRevenueDetail();
                        $order_revenue_detail->order_id = $order->id;
                        $order_revenue_detail->order_code = $order->code;
                        $order_revenue_detail->user_id = $current_user->parent->parent->parent->id;
                        $order_revenue_detail->user_email = $current_user->parent->parent->parent->email;
                        $order_revenue_detail->user_level = 2;
                        $order_revenue_detail->status = OrderRevenueDetail::STATUS_WAIT_QUYET_TOAN;
                        $order_revenue_detail->revenue_amount = $revenue_amount_level_2;
                        $order_revenue_detail->save();
                    }

                    if (isset($current_user->parent) && isset($current_user->parent->parent) && isset($current_user->parent->parent->parent) && isset($current_user->parent->parent->parent->parent)) {
                        $order_revenue_detail = new OrderRevenueDetail();
                        $order_revenue_detail->order_id = $order->id;
                        $order_revenue_detail->order_code = $order->code;
                        $order_revenue_detail->user_id = $current_user->parent->parent->parent->parent->id;
                        $order_revenue_detail->user_email = $current_user->parent->parent->parent->parent->email;
                        $order_revenue_detail->user_level = 1;
                        $order_revenue_detail->status = OrderRevenueDetail::STATUS_WAIT_QUYET_TOAN;
                        $order_revenue_detail->revenue_amount = $revenue_amount_level_1;
                        $order_revenue_detail->save();
                    }
                }

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
