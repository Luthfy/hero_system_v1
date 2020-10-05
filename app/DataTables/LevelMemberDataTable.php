<?php

namespace App\DataTables;

use App\Models\LevelMember;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LevelMemberDataTable extends DataTable
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
            ->editColumn('updated_at', function ($levelmember){
                return $levelmember->updated_at->format('yy-m-d h:i:s');
            })
            ->addColumn('action', function($levelmember) {
                return "<a href='levelmember/$levelmember->id/edit' class='text-success mr-2'><i class='far fa-edit'></i></a><a class='text-danger' onclick='delete_level_member($levelmember->id)'><i class='far fa-trash-alt'></i></a>";
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\LevelMemberDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $levelmember = LevelMember::select()->orderBy('id', 'asc');
        return $this->applyScopes($levelmember);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('levelmember_table')
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
            Column::make('name_level_member')
                    ->title('Nama Level')
                    ->addClass('text-left'),
            Column::make('description_level_member')
                    ->title('Deskripsi')
                    ->addClass('text-right'),
            Column::make('poin_level_member')
                    ->title('Poin')
                    ->addClass('text-right'),
            Column::make('bonus_sponsor')
                    ->title('Bonus Sponsor (%)')
                    ->addClass('text-right'),
            Column::make('updated_at')
                    ->title('Diperbarui pada')
                    ->addClass('text-right'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'LevelMember_' . date('YmdHis');
    }
}
