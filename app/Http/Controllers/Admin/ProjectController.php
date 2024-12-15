<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Project\ProjectStoreRequest;
use App\Model\Admin\Project;
use Illuminate\Http\Request;
use App\Model\Admin\Project as ThisModel;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;
use Validator;
use Auth;
use \stdClass;
use Response;
use Rap2hpoutre\FastExcel\FastExcel;
use PDF;
use App\Http\Controllers\Controller;
use \Carbon\Carbon;
use DB;
use App\Http\Traits\ResponseTrait;
use App\Helpers\FileHelper;
use App\Model\Common\User;

class ProjectController extends Controller
{
    use ResponseTrait;

    protected $view = 'admin.projects';
    protected $route = 'Project';

    public function index()
    {
        return view($this->view.'.index');
    }

    // Hàm phân trang, search cho datatable
    public function searchData(Request $request)
    {
        $objects = ThisModel::searchByFilter($request);

        return Datatables::of($objects)
            ->addColumn('image', function ($object) {
                return '<img class="thumbnail img-preview" width="100px" height="100px" src="' . ($object->image ? $object->image->path : '') . '">';
            })
            ->editColumn('created_at', function ($object) {
                return Carbon::parse($object->created_at)->format("d/m/Y");
            })
            ->editColumn('updated_by', function ($object) {
                return $object->user_update->name ?? '';
            })
            ->addColumn('action', function ($object) {
                $result = '<a href="' . route($this->route.'.edit',$object->id) .'" title="Sửa" class="btn btn-sm btn-primary edit"><i class="fas fa-pencil-alt"></i></a> ';
                $result .= '<a href="' . route($this->route.'.delete', $object->id) . '" title="Khóa" class="btn btn-sm btn-danger confirm"><i class="fas fa-times"></i></a>';

                return $result;
            })
            ->addColumn('title', function ($object) {
                return $object->title;
            })
            ->addColumn('address', function ($object) {
                return $object->address;
            })
            ->rawColumns(['image', 'status', 'action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function create()
    {
        return view($this->view.'.create', compact([]));
    }

    public function edit($id)
    {
        $object = ThisModel::getDataForEdit($id);

        return view($this->view.'.edit', compact(['object']));
    }

    public function store(ProjectStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $project = new Project();
            $project->fill($request->all());
            $project->save();


            FileHelper::uploadFile($request->image, 'project', $project->id, ThisModel::class, 'image', 99);

            DB::commit();
            return $this->responseSuccess();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function update(ProjectStoreRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $project = ThisModel::findOrFail($id);

            $project->fill($request->all());
            $project->save();

            if($request->image) {
                FileHelper::forceDeleteFiles($project->image->id, $project->id, ThisModel::class, 'image');
                FileHelper::uploadFile($request->image, 'project', $project->id, ThisModel::class, 'image', 99);
            }

            DB::commit();
            return $this->responseSuccess();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id)
    {
        $object = ThisModel::findOrFail($id);
        if (!$object->canDelete()) {
            $message = array(
                "message" => "Không thể khóa!",
                "alert-type" => "warning"
            );
        } else {
            $object->status = 0;
            $object->save();
            $message = array(
                "message" => "Thao tác thành công!",
                "alert-type" => "success"
            );
        }
        return redirect()->route($this->route.'.index')->with($message);
    }


    // Xuất Excel
    public function exportExcel() {
        return (new FastExcel(ThisModel::all()))->download('danh_sach_tai_khoan.xlsx', function ($object) {
            return [
                'ID' => $object->id,
                'Tên' => $object->name,
                'email' => $object->email,
                'Loại' => $object->getTypeUser($object->type),
                'Trạng thái' => $object->status == 0 ? 'Khóa' : 'Hoạt động',
            ];
        });
    }

    // Xuất PDF
    public function exportPDF() {
        $data = ThisModel::all();
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView($this->view.'.pdf', compact('data'));
        return $pdf->download('danh_sach_tai_khoan.pdf');
    }
}
