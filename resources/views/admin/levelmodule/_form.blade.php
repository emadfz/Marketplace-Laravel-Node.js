{{--@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif--}}


<div class="form-group">
        <label for="inputEmail12" class="col-md-4 control-label">
            {!! Form::label('attribute_set_id', trans("form.level_rights.workgroup"), ['class' => 'col-md-16 control-label']) !!}                                                                   
        </label>
                                            <div class="col-md-4">
                                                <div class="input-icon">
                                                    <i class="fa fa-user"></i>
                                                    {!! Form::select('level_name', ($input['levels']),$input['level_name'],['class' => 'form-control select2']) !!}
                                            </div>
                                        </div>
</div>    

 <?php 
            if(!empty($input['levelmodule']))
            { 
?>                
    <div class="form-group col-md-12 color-view bg-purple-plum bg-font-purple-plum bold">
        <div class="mt-checkbox-inline ">
            <label class="col-md-5 center">
                {{trans("form.level_rights.Modules")}}
                <span></span>
            </label>
            <label class="mt-checkbox col-md-1">
                {!! Form::checkbox("Read", 0,0, ["onClick" => "checkallread('read_access')","id"=> "read_access_select_all"]) !!}            
                {{trans("form.level_rights.Read")}}
                <span></span>
            </label>
            <label class="mt-checkbox col-md-1">
                {!! Form::checkbox("Create", 0,0, ["onClick" => "checkallread('create_access')","id"=> "create_access_select_all"]) !!}            
                {{trans("form.level_rights.Create")}}
                <span></span>
            </label>
            <label class="mt-checkbox col-md-1">
                {!! Form::checkbox("Update", 0,0, ["onClick" => "checkallread('update_access')","id"=> "update_access_select_all"]) !!}            
                {{trans("form.level_rights.Update")}}
                <span></span>
            </label>
            <label class="mt-checkbox col-md-1">
                {!! Form::checkbox("Delete", 0,0, ["onClick" => "checkallread('delete_access')","id"=> "delete_access_select_all"]) !!}            
                {{trans("form.level_rights.Delete")}}
                <span></span>
            </label>
        </div>
    </div>                
                <?php
                $flag = 0;
                foreach( $input['levelmodule'] as $values )
                {                 
                    ?> 



<div class="form-group col-md-12">
        <div class="mt-checkbox-inline">
            <label class=" col-md-5">
            {!! Form::label('attribute_set_id', @$values->module->alias_name, ['class' => 'col-md-6 control-label']) !!}    
            {!! Form::hidden("module_id[$flag]", @$values->module->id, ['class' => 'col-md-6 control-label']) !!}    
                <span></span>
            </label>
            <label class="mt-checkbox col-md-1">
            {!! Form::checkbox("read_access[$flag]", @$values->read_access,@$values->read_access, ['style'=> 'float: left;width:60%;margin-top: 5px;', 'id' => 'read_access[]' ]) !!}            
            {!! Form::hidden('id[]', @$values->id, ['class'=>'form-control','style'=> 'float: left;width:60%;margin-top: 5px;']) !!}            
            <span></span>
            </label>
            <label class="mt-checkbox col-md-1">
            {!! Form::checkbox("create_access[$flag]", @$values->create_access,@$values->create_access, ['style'=> 'float: left;width:60%;margin-top: 5px;', 'id' => 'create_access[]']) !!}            
            {!! $errors->first('create_access', '<span class="help-block">:message</span>') !!}
                <span></span>
            </label>
            <label class="mt-checkbox col-md-1">
            {!! Form::checkbox("update_access[$flag]", @$values->update_access,@$values->update_access, ['style'=> 'float: left;width:60%;margin-top: 5px;', 'id' => 'update_access[]']) !!}            
            {!! $errors->first('update_access', '<span class="help-block">:message</span>') !!}
            <span></span>
            </label>
            <label class="mt-checkbox col-md-1">
            {!! Form::checkbox("delete_access[$flag]", @$values->delete_access,@$values->delete_access, ['style'=> 'float: left;width:60%;margin-top: 5px;', 'id' => 'delete_access[]']) !!}            
            {!! $errors->first('read_access', '<span class="help-block">:message</span>') !!}
            <span></span>
            </label>
        </div>
    </div>  
<?php $flag++;} ?>
                <?php 
                    
                
            }
?>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            {!! Form::submit( $button_text, ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'level.index')}}">Cancel</a>
        </div>
    </div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>
  $(".select2").change(function(){
     level_id=$(".select2").val();
     url = "{{URL::to('admin/levelmodule/:id/edit')}}";
     url = url.replace(':id', level_id);
     window.location.href=(url);
  });
function checkallread(array_name){
    array_name=array_name;
    $('input[id="'+array_name+'[]"]').each(function(){
    if($("#"+array_name+"_select_all").is(':checked') == true){
        $(this).prop('checked',true);
    }else{
         $(this).prop('checked',false);
    }    
    });
}    
</script>
<!-- END FORM-->