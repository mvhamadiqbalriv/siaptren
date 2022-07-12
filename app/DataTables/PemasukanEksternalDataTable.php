<?php

namespace App\DataTables;

use App\Models\Keuangan\PemasukanEksternal;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PemasukanEksternalDataTable extends DataTable
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
            ->editColumn('jumlah', fn ($row) => numberFormat($row->jumlah, 0, 'Rp '))
            ->addColumn('detail', function ($row) {
                if ($row->batal) {
                    return "<p>Dibatalkan oleh $row->user_batal</p>
                    <span>Keterangan : $row->keterangan</span>";
                }

                return "<p>Diinput oleh $row->user_input</p>";
            })
            ->addColumn('action', function ($row) {
                $id = encrypt($row->id);
                $disabled = $row->batal ? 'disabled' : '';
                return "<button $disabled class='btn btn-sm btn-danger batal' type='button' data-id='$id'>Batalkan</button>";
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'detail']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Keuangan\PemasukanEksternal $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PemasukanEksternal $model)
    {
        return $model::from('pemasukan as p')
            ->leftJoin('users as ui', 'ui.username', '=', 'p.user')
            ->leftJoin('users as ub', function ($join) {
                $join->on('ub.username', '=', 'p.user_batal')
                    ->whereNotNull('p.user_batal');
            })
            ->select('p.*', 'ui.nama_lengkap as user_input', 'ub.nama_lengkap as user_batal');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('pemasukaneksternal-table')
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
            Column::make('DT_RowIndex')->title('No')->width(20)->orderable(false)->searchable(false),
            Column::make('tanggal'),
            Column::make('nama_pemasukan'),
            Column::make('jumlah'),
            Column::make('keterangan'),
            Column::make('detail'),
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
        return 'PemasukanEksternal_' . date('YmdHis');
    }
}
