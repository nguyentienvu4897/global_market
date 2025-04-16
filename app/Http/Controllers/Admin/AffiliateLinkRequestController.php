<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\AffiliateLinkRequest;
use Yajra\DataTables\DataTables;

class AffiliateLinkRequestController extends Controller
{
    protected $view = 'admin.affiliate_link_requests';
    protected $route = 'affiliate_link_requests';

    public function index() {
        return view($this->view . '.index');
    }

    public function searchData(Request $request) {
        $objects = AffiliateLinkRequest::searchByFilter($request);
        return Datatables::of($objects)
            ->editColumn('user', function ($object) {
                if ($object->user) {
                    return $object->user->name . ' - ' . $object->user->phone_number;
                }
                return '';
            })
            ->editColumn('campaign', function ($object) {
                return array_find_el(AffiliateLinkRequest::CAMPAIGNS, function($el) use ($object) {
                    return $el['id'] == $object->campaign_id;
                })['name'];
            })
            ->editColumn('status', function ($object) {
                return getStatus($object->status, AffiliateLinkRequest::STATUSES);
            })
            ->editColumn('created_at', function ($object) {
                return formatDate($object->created_at);
            })
            ->editColumn('updated_at', function ($object) {
                return formatDate($object->updated_at);
            })
            ->addColumn('action', function ($object) {
                $result = '<div class="btn-group btn-action">
                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class = "fa fa-cog"></i>
                </button>
                <div class="dropdown-menu">';
                if ($object->status == AffiliateLinkRequest::STATUS_NEW) {
                    $result = $result . ' <a href="" title="đổi trạng thái" class="dropdown-item update-status"><i class="fa fa-angle-right"></i>Đổi trạng thái</a>';
                }
                $result = $result . '</div></div>';
                return $result;
            })
            ->addIndexColumn()
            ->rawColumns(['user', 'campaign', 'status', 'created_at', 'updated_at', 'action'])
            ->make(true);
    }

    public function updateStatus(Request $request) {
        $object = AffiliateLinkRequest::find($request->affiliate_link_request_id);
        $object->status = $request->status;
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thành công'
        ]);
    }
}
