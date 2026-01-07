<?php

declare(strict_types=1);

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultiSheetUsersExport implements WithMultipleSheets
{
    use Exportable;

    protected $exports;

    public function __construct(array $exports)
    {
        $this->exports = $exports;
    }

    public function sheets(): array
    {
        return $this->exports;
    }
}
