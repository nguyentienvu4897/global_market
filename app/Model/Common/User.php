<?php

namespace App\Model\Common;

use App\Model\Admin\OrderRevenueDetail;
use App\Model\Admin\SellerRequest;
use App\Model\G7\ReceiptVoucher;
use App\Model\Uptek\G7Info;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Auth;
use App\Model\Common\File;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;

    public const SUPER_ADMIN = 1;
    public const QUAN_TRI_VIEN = 2;
    public const KHACH_HANG = 10;
    public const NGUOI_BAN_HANG = 20;
    public const CONG_TAC_VIEN = 30;

    public const USER_TYPES = [
        [
            'id' => 1,
            'name' => 'Super Admin',
        ],
        [
            'id' => 2,
            'name' => 'Quản trị viên',
        ],
        [
            'id' => 10,
            'name' => 'Khách hàng',
        ],
        [
            'id' => 20,
            'name' => 'Người bán hàng',
        ],
        [
            'id' => 30,
            'name' => 'Cộng tác viên',
        ],
    ];

    public const STATUSES = [
        [
            'id' => 1,
            'name' => 'Hoạt động',
            'type' => 'success'
        ],
        [
            'id' => 0,
            'name' => 'Khóa',
            'type' => 'danger'
        ]
    ];

    public function getTypeUser($type)
    {
        foreach (self::USER_TYPES as $item) {
            if ($item['id'] == $type) {
                return $item['name'];
                break;
            }
        }
    }

    protected $fillable = [
        'name', 'account_name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (Auth::guard('admin')->user() && !$model->created_by) $model->created_by = Auth::guard('admin')->user()->id;
            if (Auth::guard('admin')->user()) $model->updated_by = Auth::guard('admin')->user()->id;
        });

        self::saving(function ($model) {
            if (Auth::guard('admin')->user()) $model->updated_by = Auth::guard('admin')->user()->id;
        });
    }

    // Scope cho admin
    public function scopeAdmins($query)
    {
        return $query->where('type', 1)->orWhere('type', 2)->orWhere('type', 20);
    }

    // Scope cho client
    public function scopeClients($query)
    {
        return $query->where('type', 10)->orWhere('type', 20);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
        ];
    }

    public function canEdit()
    {
        if (Auth::guard('admin')->user()->canDo('Cập nhật người dùng')) return true;
        if (Auth::guard('admin')->user()->is_ctv && Auth::guard('admin')->user()->id == $this->id) return true;
        return false;
    }

    public function canDelete()
    {
        if (Auth::guard('admin')->user()->canDo('Xóa người dùng')) {
            return true;
        }
        return false;
    }


    public function user_create()
    {
        return $this->belongsTo('App\Model\Common\User', 'created_by', 'id');
    }

    public function user_update()
    {
        return $this->belongsTo('App\Model\Common\User', 'updated_by', 'id');
    }

    public function childs()
    {
        return $this->hasMany('App\Model\Common\User', 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Model\Common\User', 'parent_id', 'id');
    }

    public function sellerRequests()
    {
        return $this->hasMany(SellerRequest::class, 'user_id', 'id');
    }

    public function image()
    {
        return $this->morphOne(File::class, 'model');
    }

    public function employee()
    {
        return $this->belongsTo('App\Model\G7\G7Employee', 'employee_id', 'id');
    }

    // public function recipient()
    // {
    //     return $this->morphOne(PaymentVoucher::class, 'recipientale');
    // }

    public function receiptVoucher()
    {
        return $this->morphOne(ReceiptVoucher::class, 'payer');
    }

    public function getIsSuperAdminAttribute()
    {
        return $this->type == self::SUPER_ADMIN;
    }

    public function getIsAdminAttribute() {
        return $this->type == self::QUAN_TRI_VIEN;
    }

    public function getIsSellerAttribute() {
        return $this->type == self::NGUOI_BAN_HANG;
    }

    public function getIsCtvAttribute() {
        return $this->type == self::CONG_TAC_VIEN;
    }

    public function getAccessTypes() {
        if ($this->type == self::SUPER_ADMIN) return [self::QUAN_TRI_VIEN, self::NGUOI_BAN_HANG];
        if ($this->type == self::QUAN_TRI_VIEN) return [self::NGUOI_BAN_HANG];
        return [];
    }

    public function canDo($permission_name)
    {
        if ($this->is_super_admin) return true;
        $permission = Permission::where('name', $permission_name)->first();
        $types = PermissionHasType::where('permission_id', $permission->id)->pluck('type')->toArray();
        if (!$permission) return false;
        return in_array($this->type, $types) && $this->can($permission_name);
    }

    public static function getDataForEdit($id)
    {
        return self::where('id', $id)
            ->with([
                'roles',
                'image',
            ])
            ->firstOrFail();
    }

    public static function searchByFilter($request)
    {
        $result = self::with([
            'employee'
        ]);

        if (!empty($request->name)) {
            $result = $result->where('name', 'like', '%' . $request->name . '%');
        }

        if (!empty($request->email)) {
            $result = $result->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->status === 0 || $request->status === '0' || !empty($request->status)) {
            $result = $result->where('status', $request->status);
        }

        if (empty($request->get('order'))) {
            $result = $result->orderBy('created_at', 'DESC');
        }

        return $result;
    }

    public static function getForSelect()
    {
        return self::select(['id', 'name'])
            ->where('status', 1)
            ->orderBy('name', 'ASC')
            ->get();
    }

    public static function getMembers()
    {
        $result = self::select(['id', 'name']);

        $result = $result->where('status', 1)
            ->orderBy('name', 'ASC')
            ->get();
        return $result;
    }

    public static function getForSelectUserClients()
    {
        return self::select(['id', 'name'])
            ->where('status', 1)
            ->where('type', 10)
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function order_revenue_details()
    {
        return $this->hasMany(OrderRevenueDetail::class, 'user_id', 'id');
    }

    public function getAvatarAttribute() {
        return $this->image ? $this->image->path : asset('site/images/avatar.png');
    }

    public static function getTableList($users)
    {
        $rows = '';

        \Log::info('start export user loop');
        foreach ($users as $index => $item) {
            try {
                $rows .= '<tr style="font-size: 16px;">';
                $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black; text-align: center" >' . ($index + 1) . '</td>';
                $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . htmlspecialchars($item->name) . '</td>';
                $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . str_replace('&', ' &amp; ', $item->email) . '</td>';
                $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . str_replace('&', ' &amp; ', $item->phone_number) . '</td>';
                $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . str_replace('&', ' &amp; ', $item->account_name) . '</td>';
                $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . str_replace('&', ' &amp; ', $item->getTypeUser($item->type)) . '</td>';
                $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . str_replace('&', ' &amp; ', $item->status == 0 ? 'Khóa' : 'Hoạt động') . '</td>';
                $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . str_replace('&', ' &amp; ', $item->invite_code) . '</td>';
                $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . Carbon::parse($item->created_at)->format('d/m/Y H:i:s') . '</td>';
                $rows .= '<td style="vertical-align: center; word-wrap: break-word; border:1px solid black;" >' . Carbon::parse($item->updated_at)->format('d/m/Y H:i:s') . '</td>';

                $rows .= '</tr>';
            } catch (\Throwable $e) {
                \Log::error('Error in getTableList at item #' . $index, [
                    'item_id' => $item->id ?? 'N/A',
                    'name' => $item->name ?? '',
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                \Log::info(var_export($item, true));
            }

        }

        $table = '<table style="width: 100%">
            <thead>
                <tr style="">
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 7px"><b>STT</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 20px"><b>Họ và tên</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 40px"><b>Email</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 14px"><b>Số điện thoại</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 14px"><b>Tên đăng nhập</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 14px"><b>Loại tài khoản</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 12px"><b>Trạng thái</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 14px"><b>Mã giới thiệu</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 18px"><b>Ngày tạo</b></td>
                    <td style="vertical-align: center; word-wrap: break-word; text-align: center; border: 1px solid black; width: 18px"><b>Ngày cập nhật</b></td>
                </tr>
            </thead>
            <tbody>'
            . $rows .
            '</tbody>
        </table>';

        return $table;
    }
}
