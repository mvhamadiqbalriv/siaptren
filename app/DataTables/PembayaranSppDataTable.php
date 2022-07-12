<?php

namespace App\DataTables;

use App\Models\Keuangan\PembayaranSpp;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PembayaranSppDataTable extends DataTable
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
            ->editColumn('jumlah', function ($row) {
                return numberFormat($row->jumlah, 0, 'Rp ');
            })
            ->addColumn('action', function ($row) {
                $id = encrypt($row->id);
                $button = '<div class="btn-group-vertical"><button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false"> Pilih Aksi <i class="mdi mdi-chevron-down"></i> </button><div class="dropdown-menu" aria-labelledby="btnGroupDrop2">';

                if (Gate::allows('update ' . request()->path()) and !$row->batal) {
                    $button .= "<a class='dropdown-item action' data-jenis='batal' data-id='$id' href='javascript:void(0)'>Batal</a>";
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
     * @param \App\Models\Keuangan\PembayaranSpp $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PembayaranSpp $model)
    {
        return $model::from('pembayaran_spp as ps')
            ->leftJoin('santri', 'ps.santri_id', '=', 'santri.id')
            ->select('santri.nama_lengkap', 'ps.*');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('pembayaranspp-table')
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
            Column::make('kode_pembayaran')->title('Kode'),
            Column::make('nama_lengkap')->title('Santri'),
            Column::make('tanggal'),
            Column::make('jumlah'),
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
        return 'PembayaranSpp_' . date('YmdHis');
    }
}
