<?php

namespace App\Model\Admin;

use App\Model\Common\User;
use Illuminate\Database\Eloquent\Model;

class OrderRevenueDetail extends Model
{
    protected $table = 'order_revenue_details';

    const STATUS_PENDING = 0; // chờ xử lý
    const STATUS_PAID = 1; // đã xử lý
    const STATUS_WAIT_QUYET_TOAN = 2; // chờ quyết toán
    const STATUS_QUYET_TOAN = 3; // đã quyết toán
    const STATUS_CANCEL = 4; // đã hủy

    public const STATUSES = [
        [
            'id' => self::STATUS_PAID,
            'name' => 'Đang xử lý',
            'type' => 'success'
        ],
        [
            'id' => self::STATUS_PENDING,
            'name' => 'Chờ xử lý',
            'type' => 'warning'
        ],
        [
            'id' => self::STATUS_WAIT_QUYET_TOAN,
            'name' => 'Chờ quyết toán',
            'type' => 'warning'
        ],
        [
            'id' => self::STATUS_QUYET_TOAN,
            'name' => 'Đã quyết toán',
            'type' => 'info'
        ],
        [
            'id' => self::STATUS_CANCEL,
            'name' => 'Đã hủy',
            'type' => 'danger'
        ],
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public static function revenueReportQuery($request) {
        $users = User::query()
            ->where('users.status', 1)->where('users.type', 10)
            ->has('order_revenue_details')
            ->select('users.*',
            \DB::raw('SUM(alias.total_amount_pending) as total_amount_pending'),
            \DB::raw('SUM(alias2.total_amount_wait_payment) as total_amount_wait_payment'),
            \DB::raw('SUM(alias3.total_amount_paid) as total_amount_paid'))
            ->leftJoinSub(function($query) {
                $query->from('order_revenue_details')
                    ->leftJoin('users', 'users.id', '=', 'order_revenue_details.user_id')
                    ->select(['users.id as user_id', \DB::raw('SUM(revenue_amount) as total_amount_pending')])
                    ->whereIn('order_revenue_details.status', [self::STATUS_PENDING, self::STATUS_PAID])
                    ->groupBy('users.id');
            }, 'alias', function($join) {
                $join->on('alias.user_id', '=', 'users.id');
            })
            ->leftJoinSub(function($query) {
                $query->from('order_revenue_details')
                    ->leftJoin('users', 'users.id', '=', 'order_revenue_details.user_id')
                    ->select(['users.id as user_id',
                    \DB::raw('SUM(revenue_amount - settlement_amount) as total_amount_wait_payment')])
                    ->whereIn('order_revenue_details.status', [self::STATUS_WAIT_QUYET_TOAN])
                    ->groupBy('users.id');
            }, 'alias2', function($join) {
                $join->on('alias2.user_id', '=', 'users.id');
            })
            ->leftJoinSub(function($query) {
                $query->from('order_revenue_details')
                    ->leftJoin('users', 'users.id', '=', 'order_revenue_details.user_id')
                    ->select(['users.id as user_id',
                    \DB::raw('SUM(settlement_amount) as total_amount_paid')])
                    ->where(function($que) {
                        $que->whereIn('order_revenue_details.status', [self::STATUS_QUYET_TOAN])
                        ->orWhere(function($q) {
                            $q->whereIn('order_revenue_details.status', [self::STATUS_WAIT_QUYET_TOAN])
                            ->where('settlement_amount', '>', 0);
                        });
                    })
                    ->groupBy('users.id');
            }, 'alias3', function($join) {
                $join->on('alias3.user_id', '=', 'users.id');
            })
            ->groupBy('users.id');

        if (!empty($request->user_id)) {
            $users->where('users.id', $request->user_id);
        }

        if (!empty($request->from_date)) {
            $users->where('order_revenue_details.created_at', '>=', $request->from_date);
        }

        if (!empty($request->to_date)) {
            $users->where('order_revenue_details.created_at', '<=', $request->to_date);
        }

        if (!empty($request->status)) {
            $users->where('order_revenue_details.status', $request->status);
        }

        if (!empty($request->order_code)) {
            $users->where('order_revenue_details.order_id', $request->order_code);
        }

        return $users;
    }

    public static function searchByFilter($request) {
        $results = self::where('user_id', \Auth::guard('client')->user()->id);

        if (!empty($request->order_code)) {
            $results->where('order_code', $request->order_code);
        }

        if (!empty($request->order_employee)) {
            $results->whereHas('order', function($query) use ($request) {
                $query->where('customer_name', 'like', '%' . $request->order_employee . '%')->orWhere('customer_email', 'like', '%' . $request->order_employee . '%');
            });
        }

        if (!empty($request->status)) {
            $results->where('status', $request->status);
        }

        if (isset($request->status) && $request->status == self::STATUS_PENDING) {
            $results->where('status', self::STATUS_PENDING);
        }

        if (!empty($request->from_date)) {
            $results->where('created_at', '>=', $request->from_date);
        }

        if (!empty($request->to_date)) {
            $results->where('created_at', '<=', $request->to_date);
        }

        if (empty($request->order)) {
            $results->orderBy('id', 'desc');
        }

        return $results->get();
    }
}
