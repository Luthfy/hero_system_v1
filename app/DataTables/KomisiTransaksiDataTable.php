<?php

namespace App\DataTables;

use App\Models\KomisiTransaksi;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KomisiTransaksiDataTable extends DataTable
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
            ->addColumn('action', function ($komisi) {
                return "<a href='".url('affiliate/komisitransaksi/' . $komisi->id . '/edit')."' class='m-2'><i class='far fa-edit'></i></a><a class='text-danger m-2' onclick='delete_komisi_transaksi($komisi->id)'><i class='far fa-trash-alt'></i></a>";
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\KomisiTransaksiDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $komisi = KomisiTransaksi::select();
        return $this->applyScopes($komisi);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('komisitransaksi-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('id'),
            Column::make('jenis_komisi'),
            Column::make('besaran_komisi'),
            Column::make('jenis_besaran'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'KomisiTransaksi_' . date('YmdHis');
    }
}
