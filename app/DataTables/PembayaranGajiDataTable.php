<?php

namespace App\DataTables;

use App\Models\Keuangan\PembayaranGaji;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PembayaranGajiDataTable extends DataTable
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
            ->eloquent($query->with('asatidz:id,nama_lengkap'))
            ->skipTotalRecords()
            ->editColumn('jumlah_honor', function ($row) {
                return numberFormat($row->jumlah_honor, 0, 'Rp ');
            })
            ->addColumn('periode', function ($row) {
                return dateFormat($row->tanggal, 'F Y');
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Keuangan\PembayaranGaji $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PembayaranGaji $model)
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
            ->setTableId('pembayarangaji-table')
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
            Column::make('periode')->searchable(false)->name('tanggal'),
            Column::make('tanggal')->title('Tanggal Distribusi'),
            Column::make('asatidz.nama_lengkap')->name('asatidz.nama_lengkap')->title('Asatidz'),
            Column::make('jumlah_kehadiran')->title('Kehadiran'),
            Column::make('jumlah_honor')->title('Total Honor'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'PembayaranGaji_' . date('YmdHis');
    }
}
