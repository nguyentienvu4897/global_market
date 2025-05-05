<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Model\Common\File;
use App\Model\Common\User;

class SellerStore extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const STATUSES = [
        [
            'id' => self::STATUS_ACTIVE,
            'name' => 'Hoạt động',
            'type' => 'success'
        ],
        [
            'id' => self::STATUS_INACTIVE,
            'name' => 'Ngưng hoạt động',
            'type' => 'danger'
        ],
    ];

    protected $table = 'seller_stores';
    protected $fillable = [
        'user_id',
        'shop_name',
        'email',
        'company_name',
        'phone',
        'hotline',
        'address',
        'facebook',
        'zalo',
        'instagram',
        'youtube',
        'tiktok',
        'twitter',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logo()
    {
        return $this->morphOne(File::class, 'model')->where('custom_field', 'logo');
    }

    public function banner()
    {
        return $this->morphOne(File::class, 'model')->where('custom_field', 'banner');
    }

    public function canEdit()
    {
        return $this->status == self::STATUS_ACTIVE && $this->user_id == Auth::guard('admin')->user()->id;
    }

    public function canDelete()
    {
        return $this->status == self::STATUS_ACTIVE && $this->user_id == Auth::guard('admin')->user()->id;
    }

    public static function searchByFilter($request)
    {
        $query = self::query();
        if (!empty($request->shop_name)) {
            $query->where('shop_name', 'like', '%' . $request->shop_name . '%');
        }
        if (!empty($request->email)) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if (isset($request->status)) {
            $query->where('status', $request->status);
        }

        $query->orderBy('created_at', 'desc');
        return $query;
    }

    public static function getDataForEdit($id)
    {
        $sellerStore = self::where('id', $id)
            ->with([
                'logo',
                'banner'
            ])
            ->firstOrFail();

        return $sellerStore;
    }
}