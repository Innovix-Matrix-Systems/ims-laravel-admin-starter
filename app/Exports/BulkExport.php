<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Excel;

class BulkExport implements FromCollection, Responsable
{
    use Exportable;

    private Collection $records;

    private $fileName = 'users.csv';

    private $writerType = Excel::CSV;

    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    public function __construct(Collection $records, $name)
    {
        $this->records = $records;
        $this->fileName = $name;
    }

    /**
     * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->records;
    }
}
