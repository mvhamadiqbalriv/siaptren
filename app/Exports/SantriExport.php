<?php

namespace App\Exports;

use App\Models\Master\Santri;
use DateTime;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class SantriExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithEvents
{
    private $no;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Santri::active()->get();
    }

    public function headings(): array
    {
        return [
            'NO',
            'NAMA LENGKAP',
            'JENIS KELAMIN',
            'TEMPAT LAHIR',
            'TANGGAL LAHIR',
            'NOMOR HP',
            'TAHUN MASUK',
        ];
    }

    public function map($row): array
    {
        $tanggal_lahir = new DateTime($row->tanggal_lahir);
        $year = $tanggal_lahir->format('Y');
        $month = $tanggal_lahir->format('m');
        $day = $tanggal_lahir->format('d');

        $tanggal_lahir = \PhpOffice\PhpSpreadsheet\Shared\Date::formattedPHPToExcel($year, $month, $day);
        return [
            'NO' => ++$this->no,
            'NAMA LENGKAP' => $row->nama_lengkap,
            'JENIS KELAMIN' => $row->jenis_kelamin,
            'TEMPAT LAHIR' => $row->tempat_lahir,
            'TANGGAL LAHIR' => $tanggal_lahir,
            'NOMOR HP' => $row->nomor_handphone,
            'TAHUN MASUK' => $row->tahun_masuk
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->getStyle('A1:G1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => [
                            'rgb' => 'FFFFFF'
                        ]
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => [
                            'rgb' => '000000'
                        ]
                    ]
                ]);

                $total_row = $this->no + 1;

                $event->sheet->setAutoFilter('A1:G' . $total_row);
                $event->sheet->getStyle('A1:G' . $total_row)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000']
                        ]
                    ]
                ]);

                $event->sheet->getStyle('E2:E' . $total_row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDD);

                $event->sheet->getStyle('F2:F' . $total_row)
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            }
        ];
    }
}
