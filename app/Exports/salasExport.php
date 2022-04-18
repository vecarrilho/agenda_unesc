<?php

namespace App\Exports;

use App\Models\Sala;
use Maatwebsite\Excel\Concerns\FromCollection;

class salasExport implements FromCollection
{
    protected $data;

    public function __construct(string $data)
    {
        $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Sala::salasExport($this->data)->get();
    }
}
