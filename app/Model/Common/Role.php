<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as BaseRole;
use Auth;
use App\Model\Common\User;

class Role extends BaseRole
{
    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            if (Auth::guard('admin')->user()) $model->created_by = Auth::guard('admin')->user()->id;
            if (Auth::guard('admin')->user()) $model->updated_by = Auth::guard('admin')->user()->id;
        });

        self::updating(function($model){
            if (Auth::guard('admin')->user()) $model->updated_by = Auth::guard('admin')->user()->id;
        });
    }

    public function user_create ()
    {
        return $this->belongsTo('App\Model\Common\User', 'created_by','id');
    }

    public function user_update ()
    {
        return $this->belongsTo('App\Model\Common\User', 'updated_by','id');
    }

    public function canDelete() {
        if (!in_array($this->type, Auth::guard('admin')->user()->getAccessTypes())) return false;
        $user_count = ModelHasRole::where('role_id', $this->id)->count();
        if ($user_count > 0) return false;
        return true;
    }

    public static function searchByFilter($request) {
        $result = self::with([

        ]);

        if (!empty($request->name)) {
            $result = $result->where('display_name', 'like', '%'.$request->name.'%');
        }

        if ($request->status === 0 || $request->status === '0' || !empty($request->status)) {
            $result = $result->where('status', $request->status);
        }


        if (empty($request->get('order'))) {
            $result = $result->orderBy('created_at', 'DESC');
        }

        return $result;
    }

    public static function getForSelect() {
        $result = self::select(['id', 'display_name as name']);
        $result = $result->orderBy('display_name', 'ASC')->get();
		return $result;
    }
}
