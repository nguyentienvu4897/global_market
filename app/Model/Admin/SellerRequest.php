<?php

namespace App\Model\Admin;

use App\Model\Common\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SellerRequest extends Model
{
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;
    const STATUSES = [
        [
            'id' => self::STATUS_PENDING,
            'name' => 'Chờ duyệt',
            'type' => 'warning'
        ],
        [
            'id' => self::STATUS_APPROVED,
            'name' => 'Đã duyệt',
            'type' => 'success'
        ],
        [
            'id' => self::STATUS_REJECTED,
            'name' => 'Đã từ chối',
            'type' => 'danger'
        ],
    ];

    protected $table = 'seller_requests';
    protected $fillable = [
        'use_account_client',
        'shop_name',
        'email',
        'user_id',
        'account_name',
        'password',
        'status',
        'approved_by',
        'approved_at',
        'campaign_id',
        'aff_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public static function searchByFilter($request)
    {
        $query = self::query();
        if (!empty($request->campaign_id)) {
            $query->where('campaign_id', $request->campaign_id);
        }
        if (!empty($request->email)) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if (isset($request->status)) {
            $query->where('status', $request->status);
        }
        if (!empty($request->approved_at)) {
            $query->where('approved_at', 'like', '%' . $request->approved_at . '%');
        }
        if (!empty($request->approved_by)) {
            $query->where('approved_by', $request->approved_by);
        }
        if (!empty($request->created_at)) {
            $query->where('created_at', 'like', '%' . $request->created_at . '%');
        }
        $query->orderBy('created_at', 'desc');

        return $query;
    }

    public function canApprove()
    {
        if ($this->status == self::STATUS_PENDING && $this->approved_by == null && Auth::guard('admin')->user()->is_super_admin) return true;
        if ($this->status == self::STATUS_PENDING && $this->approved_by == null && Auth::guard('admin')->user()->canDo('Duyệt đăng ký cộng tác viên')) return true;
        return false;
    }
}
