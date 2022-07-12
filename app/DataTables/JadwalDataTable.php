<?php

namespace App\DataTables;

use App\Models\Absensi\Jadwal;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class JadwalDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $query = Jadwal::from('mapel_asatidz as mp')
            ->leftJoin('asatidz as a', 'a.id', '=', 'mp.asatidz_id')
            ->leftJoin('mata_pelajaran as mpl', 'mpl.id', '=', 'mp.mapel_id')
            ->select('mp.*', 'mpl.nama_mapel', 'mpl.hari', 'a.kode_asatidz', 'a.nama_lengkap');

        return datatables()
            ->eloquent($query)
            ->skipTotalRecords()
            ->editColumn('aktif', function ($row) {
                return $row->aktif ? 'Aktif' : 'Non-Aktif';
            })
            ->addColumn('action', function ($row) {
                $id = encrypt($row->kode_jadwal);

                return "<button class='btn btn-sm btn-outline-primary edit' data-id='$id'>Edit</button>";
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Absensi\Jadwal $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Jadwal $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('jadwal-table')
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
            Column::make('kode_jadwal'),
            Column::make('nama_mapel')->title('Mata Pelajaran'),
            Column::make('nama_lengkap')->title('Pengajar'),
            Column::make('hari'),
            Column::make('aktif'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
                ->visible(request()->user()->hasPermissionTo('update absensi/jadwal')),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Jadwal_' . date('YmdHis');
    }
}
