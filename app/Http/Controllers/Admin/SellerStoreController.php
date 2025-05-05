<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin\SellerStore as ThisModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use stdClass;
use Exception;
use App\Helpers\FileHelper;

class SellerStoreController extends Controller
{
    protected $view = 'admin.seller_stores';
    protected $route = 'seller-stores';

    public function index()
    {
        return view($this->view . '.index');
    }

    public function searchData(Request $request)
    {
        $objects = ThisModel::searchByFilter($request);
        return Datatables::of($objects)
            ->editColumn('created_at', function ($object) {
                return formatDate($object->created_at);
            })
            ->editColumn('updated_at', function ($object) {
                return formatDate($object->updated_at);
            })
            ->editColumn('status', function ($object) {
                return getStatus($object->status, ThisModel::STATUSES);
            })
            ->addColumn('action', function ($object) {
                $result = '<div class="btn-group btn-action">
                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class = "fa fa-cog"></i>
                </button>
                <div class="dropdown-menu">';
                if ($object->canEdit()) {
                    $result = $result . ' <a href="'. route($this->route.'.edit', $object->id) .'" title="Sửa" class="dropdown-item"><i class="fa fa-angle-right"></i>Thông tin cơ bản</a>';
                    $result = $result . ' <a href="'. route($this->route.'.edit_decoration', $object->id) .'" title="Sửa" class="dropdown-item"><i class="fa fa-angle-right"></i>Trang trí shop</a>';
                }
                if ($object->canDelete()) {
                    $result = $result . ' <a href="'. route($this->route.'.delete', $object->id) .'" title="Xóa" class="dropdown-item delete"><i class="fa fa-angle-right"></i>Ngừng hoạt động</a>';
                }

                $result = $result . '</div></div>';
                return $result;
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'status', 'created_at'])
            ->make(true);
    }

    public function edit($id)
    {
        $object = ThisModel::getDataForEdit($id);
        if (!$object->canEdit()) return view('not_found');
        return view($this->view . '.edit', compact('object'));
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make(
			$request->all(),
			[
				'shop_name' => 'required|unique:seller_stores,shop_name,'.$id,
				'status' => 'nullable|in:0,1',
				'phone' => 'nullable|numeric|digits_between:10,11',
				'hotline' => 'nullable|numeric|digits_between:10,11',
				'zalo' => 'nullable|numeric|digits_between:10,11',
				'address' => 'nullable',
				'logo' => 'nullable|file|mimes:jpg,jpeg,png|max:2000',
				'banner' => 'nullable|file|mimes:jpg,jpeg,png|max:2000',
			],
			[
				'shop_name.required' => 'Tên cửa hàng không được để trống',
				'shop_name.unique' => 'Tên cửa hàng đã tồn tại',
			]
		);

		$json = new stdClass();

		if ($validate->fails()) {
			$json->success = false;
            $json->errors = $validate->errors();
            $json->message = "Thao tác thất bại!";
            return Response::json($json);
		}


		DB::beginTransaction();
		try {
			$object = ThisModel::findOrFail($id);
            if (!$object->canEdit()) return response()->json(['success' => false, 'message' => 'Không có quyền!']);

			$object->shop_name = $request->shop_name;
			$object->company_name = $request->company_name;
			$object->hotline = $request->hotline;
			$object->phone = $request->phone;
			$object->address = $request->address;
			$object->facebook = $request->facebook;
			$object->instagram = $request->instagram;
			$object->tiktok = $request->tiktok;
			$object->zalo = $request->zalo;
			$object->youtube = $request->youtube;
			$object->save();

			if ($request->logo) {
				if ($object->logo) {
					FileHelper::forceDeleteFiles($object->logo->id, $object->id, ThisModel::class, 'logo');
				}
				FileHelper::uploadFile($request->logo, 'seller_stores', $object->id, ThisModel::class, 'logo', 9);
			}

			if ($request->banner) {
				if ($object->banner) {
					FileHelper::forceDeleteFiles($object->banner->id, $object->id, ThisModel::class, 'banner');
				}
				FileHelper::uploadFile($request->banner, 'seller_stores', $object->id, ThisModel::class, 'banner', 8);
			}

			DB::commit();
			$json->success = true;
			$json->message = "Thao tác thành công!";
			return Response::json($json);
		} catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new Exception($e);
        }
    }

    public function delete($id)
    {
        $object = ThisModel::find($id);
        if (!$object->canDelete()) return response()->json(['success' => false, 'message' => 'Không có quyền!']);
        $object->status = ThisModel::STATUS_INACTIVE;
        $object->save();
        return redirect()->route($this->route . '.index')->with('success', 'Ngừng hoạt động thành công');
    }

    public function editDecoration($id)
    {
        $object = ThisModel::getDataForEdit($id);
        if (!$object->canEdit()) return view('not_found');
        return view($this->view . '.edit_decoration', compact('object'));
    }

}