<?php

namespace App\Model\Admin;

use App\Model\Common\User;
use Illuminate\Database\Eloquent\Model;

class AffiliateLinkRequest extends Model
{
    protected $table = 'affiliate_link_requests';
    protected $fillable = [
        'user_id',
        'order_number',
        'url_origin',
        'campaign_id',
        'campaign_name',
        'status',
    ];

    public const STATUS_NEW = 1;
    public const STATUS_APPROVED = 2;
    public const STATUS_REJECTED = 3;
    public const STATUSES = [
        [
            'id' => self::STATUS_NEW,
            'name' => 'Mới',
            'type' => 'primary'
        ],
        [
            'id' => self::STATUS_APPROVED,
            'name' => 'Đã xử lý',
            'type' => 'success'
        ],
        [
            'id' => self::STATUS_REJECTED,
            'name' => 'Đã từ chối',
            'type' => 'danger'
        ],
    ];

    public const CAMPAIGNS = [
        [
            'id' => 1,
            'name' => 'Shopee',
        ],
        [
            'id' => 2,
            'name' => 'Tiki',
        ],
        [
            'id' => 3,
            'name' => 'Lazada',
        ],
        [
            'id' => 4,
            'name' => 'Sendo',
        ],
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function searchByFilter($request) {
        $objects = AffiliateLinkRequest::query();
        if (!empty($request->status)) {
            $objects->where('status', $request->status);
        }
        if (!empty($request->campaign_id)) {
            $objects->where('campaign_id', $request->campaign_id);
        }
        if (!empty($request->user_id)) {
            $objects->where('user_id', $request->user_id);
        }
        $objects->orderBy('created_at', 'desc');
        return $objects;
    }
}
