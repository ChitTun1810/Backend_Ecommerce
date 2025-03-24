<?php

namespace App\Imports;

use App\Services\Dashboard\ProductImportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading, SkipsEmptyRows
{
    use Importable, RemembersRowNumber;
    private $rows;

    public function model(array $row)
    {
        ++$this->rows;
        $product = (new ProductImportService($this->rows))->store($row);
        return $product;
    }

    public function headings(): array
    {
        return ['name', 'sku', 'stocks', 'brand', 'category', 'sub_category', 'sub_child', 'price', 'country', 'key_information', 'description', 'key_information', 'specification'];
    }

    public function rules(): array
    {
        return [
            '*.name'         => 'required',
            '*.sku'          => 'required',
            '*.stocks'       => 'nullable|numeric',
            '*.brand'        => 'required',
            '*.category'     => 'required',
            '*.sub_category' => 'nullable',
            '*.sub_child'    => 'nullable',
            '*.price'        => 'required|numeric',
            "*.country"      => 'nullable',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function batchSize(): int
    {
        return 50;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
