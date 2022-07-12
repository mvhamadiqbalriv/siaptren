<?php

namespace App\DataTables;

use App\Models\Master\Santri;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AlumniDataTable extends DataTable
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
            ->editColumn('nama_lengkap', function ($row) {
                return $row->nama_lengkap . " ($row->jenis_kelamin)";
            })
            ->editColumn('tanggal_lahir', function ($row) {
                return $row->tempat_lahir . ", " . dateFormat($row->tanggal_lahir, 'd F Y');
            })
            ->addColumn('action', function ($row) {
                $id = encrypt($row->kode_santri);
                $button = '<div class="btn-group-vertical"><button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false"> Pilih Aksi <i class="mdi mdi-chevron-down"></i> </button><div class="dropdown-menu" aria-labelledby="btnGroupDrop2">';

                if (Gate::allows('update ' . request()->path())) {
                    $button .= "<a class='dropdown-item action' data-jenis='edit' data-id='$id' href='javascript:void(0)'>Edit</a>";
                }

                if (Gate::allows('read ' . request()->path())) {
                    $button .= "<a class='dropdown-item action' data-jenis='detail' data-id='$id' href='javascript:void(0)'>Detail</a>";
                }

                return $button . '</div></div>';
            })
            ->addIndexColumn()
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Master\Santri $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Santri $model)
    {
        return $model->where('status', 'Lulus');
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
            ->setTableId('alumni-table')
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
            Column::make('kode_santri'),
            Column::make('nama_lengkap'),
            Column::make('tahun_masuk'),
            Column::make('tahun_lulus'),
            Column::make('pekerjaan'),
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
        return 'Alumni_' . date('YmdHis');
    }
}
