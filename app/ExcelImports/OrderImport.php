<?php
namespace App\ExcelImports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class OrderImport implements ToCollection, WithStartRow, WithMultipleSheets
{
    private $import_rows = 0;
    private $skip_rows = 0;
    private $invalid_rows = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row)
        {
            $errors = [];
            if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3]) || empty($row[4])) {
                $this->skip_rows++;
                continue;
            }
            $nation = trim($row[0]);
            $province = trim($row[1]);
            $district = trim($row[2]);
            $ward = trim($row[3]);
            $name = trim($row[4]);
            $nation = Nation::where('name', $nation)->first();
            if(!$nation) {
                $errors[] = 'Không tìm thấy quốc gia';
            } else {
                $province = Province::where('name', $province)->where('nation_id', $nation->id)->first();
                if(!$province) {
                    $errors[] = 'Không tìm thấy tỉnh/thành phố';
                } else {
                    $district = District::where('name', $district)->where('province_id', $province->id)->first();
                    if(!$district) {
                        $errors[] = 'Không tìm thấy quận/huyện';
                    } else {
                        $ward = Ward::where('name', $ward)->where('district_id', $district->id)->first();
                        if(!$ward) {
                            $errors[] = 'Không tìm thấy xã/phường';
                        }
                    }
                }
            }
            if (count($errors)) {
                $this->invalid_rows[] = [
                    'detail' => implode("\n", $errors),
                    'row' => $row,
                    'index' => $index + 2,
                ];
                $this->skip_rows++;
                continue;
            }
            $exist = Hamlet::where('name', $name)->where('ward_id', $ward->id)->first();
            if($exist) {
                $errors[] = 'Đã tồn tại';
            }
            if(count($errors)) {
                $this->invalid_rows[] = [
                    'detail' => implode("\n", $errors),
                    'row' => $row,
                    'index' => $index + 2,
                ];
                $this->skip_rows++;
                continue;
            }

            $hamlet = new Hamlet();
            $hamlet->status = 1;
            $hamlet->name = $name;
            $hamlet->ward_id = $ward->id;

            $hamlet->save();
            $this->import_rows++;
        }
    }

    public function startRow(): int
    {
        return 2;
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }

    public function getImportCount(): int
    {
        return $this->import_rows;
    }

    public function getSkipCount(): int
    {
        return $this->skip_rows;
    }

    public function getInvalidRow()
    {
        return $this->invalid_rows;
    }
}
