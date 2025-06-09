<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\AffiliateLinkRequest;
use Yajra\DataTables\DataTables;
use Mail;
use Auth;
use App\Mail\AffiliateLinkRequestToCtvMail;
use App\Mail\AffiliateLinkRequestToCustomerMail;
use App\Model\Admin\Product;

class AffiliateLinkRequestController extends Controller
{
    protected $view = 'admin.affiliate_link_requests';
    protected $route = 'affiliate-link-requests';

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
            ->editColumn('approved_by', function ($object) {
                return $object->approvedBy ? $object->approvedBy->name : '';
            })
            ->editColumn('approved_at', function ($object) {
                return formatDate($object->approved_at);
            })
            ->addColumn('action', function ($object) {
                $result = '<div class="btn-group btn-action">
                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class = "fa fa-cog"></i>
                </button>
                <div class="dropdown-menu">';
                if ($object->canChangeStatus()) {
                    $result = $result . ' <a href="" title="đổi trạng thái" class="dropdown-item update-status"><i class="fa fa-angle-right"></i>Đổi trạng thái</a>';
                }
                if ($object->canSendEmail()) {
                    $result = $result . ' <a href="javascript:void(0)" title="Gửi email" class="dropdown-item send-email" data-href="' . route($this->route . '.send-email', $object->id) . '"><i class="fa fa-angle-right"></i>Gửi email xác nhận</a>';
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
        if (!$object->canChangeStatus()) return response()->json(['success' => false, 'message' => 'Không có quyền!']);

        $object->status = $request->status;
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thành công'
        ]);
    }

    public function sendEmail(Request $request, $id) {
        $object = AffiliateLinkRequest::find($id);
        if (!$object->canSendEmail()) return response()->json(['success' => false, 'message' => 'Bạn không có quyền gửi email xác nhận yêu cầu này']);

        $product = Product::find($request->product_id);
        Mail::to($object->user->email)->send(new AffiliateLinkRequestToCustomerMail($object->user, $object, $product));
        // Mail::to('vudev4897@gmail.com')->send(new AffiliateLinkRequestToCustomerMail($object->user, $object, $product));

        $object->status = AffiliateLinkRequest::STATUS_APPROVED;
        $object->approved_by = Auth::guard('admin')->user()->id;
        $object->approved_at = now();
        $object->save();

        return response()->json(['success' => true, 'message' => 'Gửi email xác nhận thành công']);
    }
}
