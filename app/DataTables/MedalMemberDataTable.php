<?php

namespace App\DataTables;

use App\Models\Medal;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MedalMemberDataTable extends DataTable
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
            ->rawColumns(['icon_medal','action', 'persyaratan_medal'])
            ->addColumn('action', function ($medal) {
                return "<a href='".url('affiliate/medalmember/' . $medal->id . '/edit')."' class='m-2'><i class='far fa-edit'></i></a><a class='text-danger m-2' onclick='delete_medal_member($medal->id)'><i class='far fa-trash-alt'></i></a>";
            })
            ->editColumn('icon_medal', function ($medal) {
                $url = Storage::url($medal->icon_medal);
                return '<img src="'.$url.'" border="0" width="40" class="img-rounded" align="center" />';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\MedalMemberDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $medal = Medal::select()->orderBy('id', 'asc');
        return $this->applyScopes($medal);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('medalmember_table')
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
            Column::computed('icon_medal'),
            Column::make('name_medal'),
            Column::make('max_penarikan'),
            Column::make('min_saldo'),
            Column::make('reward_medal'),
            Column::make('persyaratan_medal'),
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
        return 'MedalMember_' . date('YmdHis');
    }
}
