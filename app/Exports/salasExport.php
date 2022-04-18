<?php

namespace App\Exports;

use App\Models\Sala;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class salasExport implements FromCollection, WithHeadings, ShouldAutoSize
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

    public function headings(): array
    {
        return [
            'Nome',
            'Bloco',
            'Hora',
        ];
    }
}
