<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\Datatables\Services\DataTable;

class UsersDataTable extends DataTable {
    // protected $printPreview  = 'path.to.print.preview.view';

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax() {
        return $this->datatables
                        ->eloquent($this->query())
                        ->addColumn('action', '<a id="javascript:;">View</a>')
                        ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query() {
        #$users = User::query();
        $users = User::select();
        return $this->applyScopes($users);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html() {
        return $this->builder()
                        ->columns($this->getColumns())
                        ->ajax('')
                        ->addAction(['width' => '80px'])
                        //->parameters($this->getBuilderParameters());
                        ->parameters([
                            'order' => [[0, 'asc']],
                            //'dom' => 'lBfrtip',
                            //Ref link https://datatables.net/examples/basic_init/dom.html
                            //'dom' => '<"top"flpi<"clear">>rt<"bottom"ip<"clear">>',
                            //'dom' => '<"top"i>rt<"bottom"flp><"clear">',
                            'dom' => '<"top"lifpB>rt<"bottom"ip><"clear">',
                            //'pagingType' => 'full_numbers',
                            'buttons' => [
                                //'create',
                                [
                                    'extend' => 'collection',
                                    'text' => '<i class="fa fa-download"></i> Export',
                                    'buttons' => [
                                        'csv',
                                        'excel',
                                        'pdf',
                                    ],
                                ],
                                'print',
                                'reset',
                                'reload',
                            ],
        ]);
        
    }

    private function getColumns() {
        return ['id','name','email','created_at','updated_at',];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename() {
        return 'Users';
    }

}
