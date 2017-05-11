<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskController extends Controller {

    public function index() {
        $tasks = [
            [
                'name' => 'Design New Dashboard',
                'progress' => '87',
                'color' => 'danger'
            ],
            [
                'name' => 'Create Home Page',
                'progress' => '76',
                'color' => 'warning'
            ],
            [
                'name' => 'Some Other Task',
                'progress' => '32',
                'color' => 'success'
            ],
            [
                'name' => 'Start Building Website',
                'progress' => '56',
                'color' => 'info'
            ],
            [
                'name' => 'Develop an Awesome Algorithm',
                'progress' => '10',
                'color' => 'success'
            ]
        ];
        
        $page_title = "Task";
        $page_description = "Task Description";
        return view('admin.dashboard.test', compact('tasks','page_title','page_description'));
        
        //ex: $data['tasks'] = [], $data['page_title']
        //ex: return view('admin.dashboard.test')->with($data);
    }

}
