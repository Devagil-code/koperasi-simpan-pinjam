<?php

namespace App\Exports;

use App\Anggota;

use Maatwebsite\Excel\Concerns\{FromView};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\View\View;

class AnggotaExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $anggota;

    public function __construct($anggota)
    {
        $this->anggota = $anggota;
    }

    public function collection()
    {
        return $this->anggota;
    }

    public function view(): View
    {
        return view('excell.anggota', [
            'anggota' => $this->anggota
        ]);
    }
}
