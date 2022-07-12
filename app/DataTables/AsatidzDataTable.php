<?php

namespace App\DataTables;

use App\Models\Master\Asatidz;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AsatidzDataTable extends DataTable
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
            ->editColumn('tanggal_lahir', function ($row) {
                return $row->tempat_lahir . ", " . dateFormat($row->tanggal_lahir, 'd F Y');
            })
            ->editColumn('aktif', function ($row) {
                return $row->aktif ? 'Aktif' : 'Non-Aktif';
            })
            ->editColumn('upah_pertemuan', function ($row) {
                return numberFormat($row->upah_pertemuan, 0, 'Rp ');
            })
            ->addColumn('action', function ($row) {
                $id = encrypt($row->kode_asatidz);
                $button = '<div class="btn-group-vertical"><button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false"> Pilih Aksi <i class="mdi mdi-chevron-down"></i> </button><div class="dropdown-menu" aria-labelledby="btnGroupDrop2">';

                if (Gate::allows('update ' . request()->path())) {
                    $button .= "<a class='dropdown-item action' data-jenis='edit' data-id='$id' href='javascript:void(0)'>Edit</a>";
                    if (request()->user()->hasRole('admin') and $row->aktif) {
                        $button .= "<a class='dropdown-item action' data-jenis='upload' data-id='$id' href='javascript:void(0)'>Upload Berkas</a>";
                    }
                }

                $button .= "<a class='dropdown-item action' data-jenis='detail' data-id='$id' href='javascript:void(0)'>Detail</a>";

                return $button . '</div></div>';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'aktif']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Master\Asatidz $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Asatidz $model)
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
            ->parameters(['searchDelay' => 1000, 'responsive' => ['details' => ['display' => '$.fn.dataTable.Responsive.display.childRowImmediate']]])
            ->setTableId('asatidz-table')
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
            Column::make('DT_RowIndex')->width(20)->orderable(false)->searchable(false)->title('No'),
            Column::make('kode_asatidz')->title('Kode'),
            Column::make('nik')->title('NIK'),
            Column::make('nama_lengkap'),
            Column::make('tanggal_lahir'),
            Column::make('upah_pertemuan'),
            Column::make('aktif'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Asatidz_' . date('YmdHis');
    }
}
