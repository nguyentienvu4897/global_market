<?php

namespace App\Http\Controllers\Admin;

use App\ExcelExports\OrderExcel;
use App\ExcelImports\OrderImport;
use App\Model\Admin\Order;
use Illuminate\Http\Request;
use App\Model\Admin\Order as ThisModel;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use \stdClass;

use Rap2hpoutre\FastExcel\FastExcel;
use PDF;
use App\Http\Controllers\Controller;
use \Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Helpers\FileHelper;
use App\Model\Admin\OrderRevenueDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Model\Common\Customer;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    protected $view = 'admin.orders';
    protected $route = 'orders';

    public function index()
    {
        return view($this->view . '.index');
    }

    // Hàm lấy data cho bảng list
    public function searchData(Request $request)
    {
        $objects = ThisModel::searchByFilter($request);
        return Datatables::of($objects)
            ->addColumn('total_price', function ($object) {
                return number_format($object->total_price);
            })
            ->editColumn('code', function ($object) {
                return '<a href = "'.route('orders.show', $object->id).'" title = "Xem chi tiết">' . $object->code . '</a>';
            })
            ->editColumn('type', function ($object) {
                return $object->type == 0 ? 'Đơn hàng thường' : 'Đơn hàng affiliate';
            })
            ->editColumn('code_client', function ($object) {
                return '<a href = "javascript:void(0)" title = "Xem chi tiết" class="show-order-client">' . $object->code . '</a>';
            })
            ->editColumn('created_at', function ($object) {
                return $object->type == 0 ? formatDate($object->created_at) : formatDate($object->aff_order_at);
            })
            ->addColumn('action', function ($object) {
                $result = '<div class="btn-group btn-action">
                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class = "fa fa-cog"></i>
                </button>
                <div class="dropdown-menu">';
                if ($object->canUpdateStatus()) {
                    $result = $result . ' <a href="" title="đổi trạng thái" class="dropdown-item update-status"><i class="fa fa-angle-right"></i>Đổi trạng thái</a>';
                }
                if ($object->canView()) {
                    $result = $result . ' <a href="'.route('orders.show', $object->id).'" title="xem chi tiết" class="dropdown-item"><i class="fa fa-angle-right"></i>Xem chi tiết</a>';
                }
                $result = $result . '</div></div>';
                return $result;
            })
            ->addColumn('action_client', function ($object) {
                $result = '<div class="btn-group btn-action">
                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class = "fa fa-cog"></i>
                </button>
                <div class="dropdown-menu">';
                if ($object->type == 0) {
                    $result = $result . ' <a href="" title="Hủy đơn hàng" class="dropdown-item update-status"><i class="fa fa-angle-right"></i>Hủy đơn hàng</a>';
                    $result = $result . ' <a href="'.route('orders.show', $object->id).'" title="xem chi tiết" class="dropdown-item"><i class="fa fa-angle-right"></i>Xem chi tiết</a>';
                }
                $result = $result . '</div></div>';
                return $result;
            })
            ->addIndexColumn()
            ->rawColumns(['code', 'action', 'action_client', 'code_client'])
            ->make(true);
    }

    public function show(Request $request, $id) {
        $order = Order::query()->with(['details.product'])->find($id);
//        $order->payment_method_name = Order::PAYMENT_METHODS[$order->payment_method];

        return view($this->view . '.show', compact('order'));
    }

    public function updateStatus(Request $request)
    {
        $order = Order::query()->find($request->order_id);
        if (!$order->canUpdateStatus()) {
            return Response::json(['success' => false, 'message' => 'Không có quyền!']);
        }
        $order->status = $request->status;
        $order->save();
        $order_revenue_details = OrderRevenueDetail::query()->where('order_id', $order->id)->get();
        foreach ($order_revenue_details as $order_revenue_detail) {
            if ($order->status == Order::MOI) {
                $order_revenue_detail->status = OrderRevenueDetail::STATUS_PENDING;
            } else if ($order->status == Order::DUYET) {
                $order_revenue_detail->status = OrderRevenueDetail::STATUS_PAID;
            } else if ($order->status == Order::THANH_CONG) {
                $order_revenue_detail->status = OrderRevenueDetail::STATUS_WAIT_QUYET_TOAN;
            } else if ($order->status == Order::HUY) {
                $order_revenue_detail->status = OrderRevenueDetail::STATUS_CANCEL;
            }
            $order_revenue_detail->save();
        }

        return Response::json(['success' => true, 'message' => 'cập nhật trạng thái đơn hàng thành công']);
    }

    public function exportList(Request $request) {
        if (!Auth::guard('admin')->user()->canDo('Xuất excel đơn hàng')) {
            return view('not_found');
        }
        $data = Order::searchByFilter($request)->where('type', 0)->values();
        $result['CHI_TIET'] = Order::getTableList($data);
        $result['COLSPAN'] = 8;
        $result['FROM_DATE'] = $request->startDate ? Carbon::parse($request->startDate)->format('d/m/Y') : '';
        $result['TO_DATE'] = $request->endDate ? Carbon::parse($request->endDate)->format('d/m/Y') : '';

        return (new OrderExcel())
            ->forData($result)
            ->download('danh_sach_don_hang.xlsx');
    }

    // Import Excel
	public function importExcel(Request $request) {
        if (!Auth::guard('admin')->user()->canDo('Import excel đơn hàng')) {
            return Response::json(['success' => false, 'message' => 'Không có quyền!']);
        }
		$validate = Validator::make(
			$request->all(),
			[
                'file' => 'required|file|mimes:xlsx,xls,csv,txt',
			],
			[
				'file.required' => 'Không được để trống',
				'file.file' => 'Không hợp lệ',
				'file.mimes' => 'Không hợp lệ',
			]
		);

		$json = new stdClass();

        if ($validate->fails()) {
            $json->success = false;
            $json->errors = $validate->errors();
            $json->message = "Import thất bại!";
            return Response::json($json);
        }
        DB::beginTransaction();
        try {
			$import = new OrderImport;
			Excel::import($import, $request->file('file'));

            DB::commit();

            $json->success = true;
            $json->details = [
                'import' => $import->getImportCount(),
                'skip' => $import->getSkipCount(),
                'invalid_rows' => $import->getInvalidRow(),
            ];
            $json->message = "Import thành công!";
            return Response::json($json);
        } catch (Exception $e) {
            DB::rollBack();
            $json->success = false;
            $json->message = "Đã có lỗi xảy ra!";
            return Response::json($json);
        }
	}
}
