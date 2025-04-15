<?php

namespace App\Exports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

class ProdukExport implements FromCollection, WithHeadings, WithEvents
{
    public function collection()
{
    return Produk::all()->map(function ($item) {
        return [
            $item->title,
            $item->price,
            $item->description,
            $item->stock,
        ];
    });
}


public function headings(): array
{
    return ['Nama Produk', 'Harga', 'description', 'Stok'];
}


    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $event->sheet->setCellValue('A1', 'Daftar Produk');
                $event->sheet->mergeCells('A1:D1');
                $event->sheet->getStyle('A1')->getFont()->setSize(14);
            },
        ];
    }
}
