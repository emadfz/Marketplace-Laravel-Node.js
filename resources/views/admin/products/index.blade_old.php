@extends('admin.layouts.app')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Product <small><a href="{{ route(config('project.admin_route').'products.create') }}" class="btn btn-warning btn-sm">New Product</a></small></h3>
                    <div class="box-tools">  
                        {!! Form::open(['route' => 'admin.products.index', 'method'=>'get', 'class'=>'form-inline']) !!}
                        <div class="input-group {!! $errors->has('q') ? 'has-error' : '' !!}">
                            {!! Form::text('q', isset($q) ? $q : null, ['class'=>'form-control', 'placeholder' => 'Type name / model...']) !!}
                            {!! $errors->first('q', '<p class="help-block">:message</p>') !!}

                            <div class="input-group-btn">
                                {!! Form::submit('Search', ['class'=>'btn btn-primary']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Model</td>
                                <td>Category</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->model}}</td>
                                <td>
                                    @foreach ($product->categories as $category)
                                    <span class="label label-primary">
                                        <i class="fa fa-btn fa-tags"></i>
                                        {{ $category->title }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    {!! Form::model($product, ['route' => ['admin.products.destroy', encrypt($product->id)], 'method' => 'delete', 'class' => 'form-inline'] ) !!}
                                    <a href="{{ route(config('project.admin_route').'products.edit', encrypt($product->id))}}">Edit</a> |
                                    {!! Form::submit('delete', ['class'=>'btn btn-xs btn-danger js-submit-confirm']) !!}
                                    {!! Form::close()!!}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="box-footer clearfix">
                    {!! $products->links() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
