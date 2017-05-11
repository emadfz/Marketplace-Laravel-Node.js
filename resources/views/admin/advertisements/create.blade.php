@extends('admin.layouts.app')
@section('content')

<div class="row">    
    <div class="col-md-12">
                       
        
        <div class="portlet light bordered"> 
            <div class="portlet-title" >
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>                    
                        <span class="caption-subject">Advertisements List</span>                                         
                    </div> 
            </div> 
            @include('admin.advertisements.advertisetab')
            
            <div class="portlet-body form"> 
                    @include('admin.advertisements._form')
            </div>
        </div>
    </div>
</div>
@endsection