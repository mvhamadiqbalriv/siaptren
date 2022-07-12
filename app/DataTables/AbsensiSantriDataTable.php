<?php

namespace App\DataTables;

use App\Models\Absensi\AbsensiSantri;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AbsensiSantriDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->skipTotalRecords()
            ->editColumn('kehadiran', function ($row) {
                $kehadiran = [
                    'H' => 'Hadir',
                    'S' => 'Sakit',
                    'I' => 'Izin',
                    'A' => 'Tanpa Keterangan'
                ];

                return $kehadiran[$row->kehadiran];
            })
            ->editColumn('keterangan', function ($row) {
                return $row->keterangan ?? '-';
            })
            ->addColumn('action', function ($row) {
                $id = encrypt($row->id);
                return "<button class='btn btn-sm btn-outline-primary edit' data-id='$id'>Edit</button>";
            })
            ->addIndexColumn()
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Absensi\AbsensiSantri $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AbsensiSantri $model)
    {
        return $model::from('absensi_santri as as')
            ->leftJoin('santri as s', 's.id', '=', 'as.santri_id')
            ->select('as.*', 's.nama_lengkap');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('absensisantri-table')
            ->parameters(['searchDelay' => 1000, 'responsive' => ['details' => ['display' => '$.fn.dataTable.Responsive.display.childRowImmediate']]])
            ->addTableClass('table-striped')
            ->columns($this->getColumns())
            ->orderBy(1)
            ->languagePaginatePrevious('&larr;')
            ->languagePaginateNext('&rarr;')
            ->minifiedAjax();
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->width(20)->title('No')->orderable(false)->searchable(false),
            Column::make('tanggal'),
            Column::make('nama_lengkap')->title('Santri'),
            Column::make('kehadiran'),
            Column::make('keterangan'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
                ->visible(request()->user()->hasPermissionTo('update absensi/data/santri')),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'AbsensiSantri_' . date('YmdHis');
    }
}
