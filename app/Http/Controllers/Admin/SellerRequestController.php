<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\SellerRequest;
use Yajra\DataTables\DataTables;
use App\Model\Admin\SellerStore;
use App\Model\Common\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SellerRequestSuccessMail;

class SellerRequestController extends Controller
{
    protected $view = 'admin.seller_requests';
    protected $route = 'seller-requests';

    public function index()
    {
        return view($this->view . '.index');
    }

    public function searchData(Request $request)
    {
        $objects = SellerRequest::searchByFilter($request);
        return Datatables::of($objects)
            ->editColumn('created_at', function ($object) {
                return formatDate($object->created_at);
            })
            ->editColumn('status', function ($object) {
                return getStatus($object->status, SellerRequest::STATUSES);
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
                if ($object->canApprove()) {
                    $result = $result . ' <a href="'. route($this->route.'.approve', $object->id) .'" title="Duyệt" class="dropdown-item approve"><i class="fa fa-angle-right"></i>Duyệt</a>';
                }
                if ($object->canReject()) {
                    $result = $result . ' <a href="'. route($this->route.'.reject', $object->id) .'" title="Từ chối" class="dropdown-item reject"><i class="fa fa-angle-right"></i>Từ chối</a>';
                }

                $result = $result . '</div></div>';
                return $result;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function updateStatus(Request $request)
    {
        $sellerRequest = SellerRequest::find($request->id);
        $sellerRequest->status = $request->status;
        $sellerRequest->save();
        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thành công',
        ]);
    }

    public function approve(Request $request)
    {
        $sellerRequest = SellerRequest::find($request->id);
        $sellerRequest->status = SellerRequest::STATUS_APPROVED;
        $sellerRequest->approved_by = Auth::guard('admin')->user()->id;
        $sellerRequest->approved_at = now();
        $sellerRequest->save();

        if (!$sellerRequest->use_account_client) {
            $user = new User();
            $user->name = $sellerRequest->shop_name;
			$user->email = $sellerRequest->email;
            $user->account_name = $sellerRequest->account_name;
            $user->password = bcrypt($sellerRequest->password);
            $user->type = 20;
            $user->status = 1;
            $user->save();
        } else {
            $user = User::query()->where('id', $sellerRequest->user_id)->first();
            $user->type = 20;
            $user->save();
        }

        $seller_store = new SellerStore();
        $seller_store->user_id = $user->id;
        $seller_store->shop_name = $sellerRequest->shop_name;
        $seller_store->email = $sellerRequest->email;
        $seller_store->status = SellerStore::STATUS_ACTIVE;
        $seller_store->save();

        Mail::to($user->email)->send(new SellerRequestSuccessMail($sellerRequest));

        $message = array(
            "message" => "Duyệt yêu cầu thành công!",
            "alert-type" => "success"
        );

        return redirect()->route($this->route . '.index')->with($message);
    }

    public function reject(Request $request)
    {
        $sellerRequest = SellerRequest::find($request->id);
        $sellerRequest->status = SellerRequest::STATUS_REJECTED;
        $sellerRequest->approved_by = Auth::guard('admin')->user()->id;
        $sellerRequest->approved_at = now();
        $sellerRequest->save();
        $message = array(
            "message" => "Từ chối yêu cầu thành công!",
            "alert-type" => "success"
        );

        return redirect()->route($this->route . '.index')->with($message);
    }
}
