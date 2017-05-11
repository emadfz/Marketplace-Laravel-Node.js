@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Category <small><a href="{{ route(config('project.admin_route').'categories.create') }}" class="btn btn-warning btn-sm">New Category</a></small></h3>
                    <div class="box-tools">
                        {!! Form::open(['route' => 'admin.categories.index', 'method'=>'get', 'class'=>'form-inline']) !!}
                        <div class="input-group {!! $errors->has('q') ? 'has-error' : '' !!}">
                            {!! Form::text('q', isset($q) ? $q : null, ['class'=>'form-control input-sm pull-right', 'placeholder' => 'Search category...']) !!}
                            {!! $errors->first('q', '<p class="help-block">:message</p>') !!}

                            <div class="input-group-btn">
                                {!! Form::submit('Search', ['class'=>'btn btn-sm btn-default']) !!}
    <!--                            <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>-->
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Parent</th>
                                <th>Description</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        print_r($attributeset);
                        ?>
                            @foreach($attributeset as $category)
                            <tr>
                                <td>{{ $category->title }}</td>
                                <td>{{ $category->parent ? $category->parent->title : 'Root' }}</td>
                                <td>{{ $category->description ? $category->description : '...' }}</td>
                                <td>
                                    {!! Form::model($category, ['route' => ['admin.categories.destroy', $category], 'method' => 'delete', 'class' => 'form-inline'] ) !!}
                                    <a href="{{ route(config('project.admin_route').'categories.edit', $category->id)}}">Edit</a> |
                                    {!! Form::submit('delete', ['class'=>'btn btn-xs btn-danger js-submit-confirm']) !!}
                                    {!! Form::close()!!}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="box-footer clearfix">
                    {!! $categories->links() !!}
                </div>


            </div><!-- /.box-header -->
        </div>
    </div>
</div>
@endsection
