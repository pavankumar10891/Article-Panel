<?php

namespace App\Imports;

use Throwable;
use App\Models\TaskMangement;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;


class ImportTask implements ToModel,WithStartRow,WithValidation,SkipsOnError,SkipsOnFailure
{
    use Importable,SkipsErrors, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function getErrors()
    {
        return $this->errors;
    }
    public function rules(): array
    {
        return [
            '*.0' => 'required',
            '*.1' => 'required',
            '*.2' => 'required',
            '*.3' => 'required',
            '*.4' => 'required',
        ];

    }

    public function validationMessages()
    {
        return [
            '0.required' => 'Title field is required',
            '1.required' => 'keyword field is required',
            '2.required' => 'word count field is required',
            '3.required' => 'guideline field is required',
            '4.required' => 'content field is required',
        ];
    }
    
    public function model(array $row)
    {
        return new TaskMangement([
            'created_user_id'   => auth()->user()->id,
            'title'             => $row[0],
            'keyword'           => $row[1],
            'word_count'        => $row[2],
            'guideline'         => $row[3],
            'content'           => $row[4],
        ]);
    }
    
    public function startRow(): int
    {
        return 2;
    }


}
