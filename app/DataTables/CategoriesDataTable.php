<?php

namespace App\DataTables;

use App\Models\Category;
use Yajra\Datatables\Services\DataTable;

class CategoriesDataTable extends DataTable {
    // protected $printPreview  = 'path.to.print.preview.view';

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax() {
        $categories = Category::select()->where('status','=','Active');
        return $this->datatables
                        ->of($categories)
                        ->editColumn('action', function($category) {
                            return '<a href="'.route('admin.categories.edit', $category->id).'">Edit</a>';
                        })
                        ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query() {
        $categories = Category::select()->where('status','=','Active');
        return $this->applyScopes($categories);
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
                        ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns() {
        return [
            'id',
            'title',
            'description',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename() {
        return 'categories';
    }

}
