{{--@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif--}}


<!-- BEGIN FORM-->

<div  class="form-body">
    <div class="form-group required {!! $errors->has('name') ? 'has-error' : '' !!}">
        {!! Form::label('name', trans("form.occasions.name"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">
            {!! Form::text('name', @$occasion->name, ['class'=>'form-control', 'placeholder'=>"Enter Occasion Name"]) !!}
            {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="form-group required {!! $errors->has('status') ? 'has-error' : '' !!}">
        {!! Form::label('status', trans("form.occasions.status"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">
            {!! Form::select('status', array(''=>'select','Active'=>'Active','Inactive'=>'Inactive'),@$occasion->status, ['class'=>'form-control']) !!}
            {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
        </div>
    </div>    
    <div class="form-group required {!! $errors->has('status') ? 'has-error' : '' !!}">
        {!! Form::label('start_date', trans("form.occasions.date_range"), ['class' => 'col-md-3 control-label']) !!}    
        <div class="col-md-4">            
            <div class="input-group input-large date-picker input-daterange" data-date-format="dd-mm-yyyy">
                <span class="input-group-addon"> From </span>
                {!! Form::text('start_date', @$occasion->start_date, ['class'=>'form-control', 'placeholder'=>"Start Date"]) !!}
                <span class="input-group-addon"> to </span>
                {!! Form::text('end_date', @$occasion->end_date, ['class'=>'form-control', 'placeholder'=>"End Date"]) !!}
            </div>
            {!! $errors->first('start_date', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div id="image_container">
        <?php             
        if (isset($occasion)) {
            foreach ($occasion->Files as $key=>$row) {                
                echo '<input type="hidden" name="image[]" value="' . $row->path . '"/>';
                //$images[] = $row->path;                
                $images[$key]['path']=getImageFullPath($row->path,'small');
                $images[$key]['name']=$row->path;
            }

            $fileArray = json_encode(@$images, JSON_HEX_APOS);
        } 
        ?>
    </div>
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">            
            {!! Form::submit($button_name, ['class'=>'btn btn-primary']) !!}
            <a class="btn default" href="{{route(config('project.admin_route').'occasions.index')}}">{{trans("form.occasions.btn_cancel")}}</a>
        </div>
    </div>
</div>





<!-- END FORM-->
@push('styles') 



<link href="{{ asset('assets/admin/global/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/plugins/dropzone/basic.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('assets/admin/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/css/components.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('assets/admin/global/css/jquery.fileupload.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/global/css/jquery.fileupload-ui.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('assets/admin/global/plugins/dropzone/dropzone.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/dropzone/form-dropzone.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/admin/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/admin/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>        
<script src="{{ asset('assets/admin/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/pages/scripts/form-input-mask.min.js') }}" type="text/javascript"></script>  
<script src="{{ asset('assets/admin/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>  
<script src="{{ asset('assets/admin/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>  

<script src="{{ asset('assets/admin/pages/scripts/vendor/jquery.ui.widget.js') }}" type="text/javascript"></script>  
<script src="{{ asset('assets/admin/pages/scripts/tmpl.min.js') }}"></script>
<script src="{{ asset('assets/admin/pages/scripts/jquery.fileupload.js') }}" type="text/javascript"></script>  
<script src="{{ asset('assets/admin/pages/scripts/jquery.fileupload-process.js') }}" type="text/javascript"></script>  
<script src="{{ asset('assets/admin/pages/scripts/jquery.fileupload-ui.js') }}" type="text/javascript"></script>


<script>
Dropzone.autoDiscover = false;

var fileArray = '<?php echo (isset($occasion)) ? $fileArray : ""; ?>';

var myDropzone = new Dropzone("#my-dropzone", {
    //autoProcessQueue: false,
    acceptedFiles: "image/*",
    maxFiles: 5, // Number of files at a time
    maxFilesize: 2, //in MB,
    url: '<?php echo URL("admin/occasions/image/uploader"); ?>',    
    addRemoveLinks: true,    
    init: function() {
                this.on("sending", function(file, xhr, formData){                    
                        formData.append("module", "occasions");
                });
    },
    headers: {
        'X-CSRF-Token': "<?php echo csrf_token(); ?>"
                //xhr.setRequestHeader('X-CSRF-Token', '{{ csrf_token() }}')
    },
    success: function (response, data, cal) {
       
        //data.path=$('#image').val()+","+data.path;
        $('#image_container').append('<input type="hidden" name="image[]" value="' + data.path + '"/>')
    },
    complete: function (file) {        
        var pre = this.previewsContainer;
        $(pre).find('.dz-preview').removeClass().addClass('dz-preview dz-processing dz-success dz-complete dz-image-preview');
    },
//            accept: function (file, done) {
//                
//                console.log(file);
//                if ((file.type).toLowerCase() != "image/jpg" &&
//                        (file.type).toLowerCase() != "image/gif" &&
//                        (file.type).toLowerCase() != "image/jpeg" &&
//                        (file.type).toLowerCase() != "image/png"
//                        ) {
//                    done("Invalid file");
//                }
//                else {
//                    done();
//                }
//            },
});


if (fileArray) {
    $(function () {
        fileArrayobject = JSON.parse(fileArray);
        $.each(fileArrayobject, function (index, value) {


            var mockFile = {name: value.name, size: 12345};

            myDropzone.options.addedfile.call(myDropzone, mockFile);

            myDropzone.options.thumbnail.call(myDropzone, mockFile,  value.path);



        });
        $('.dz-preview').removeClass().addClass('dz-preview dz-processing dz-success dz-complete dz-image-preview');
        $('.dz-remove').click(function(e){
            e.stopPropagation();
            filename=$(this).parent().find('.dz-details .dz-filename span').html();
            if(filename && filename!='undefined'){
                 $.ajax({url: "{{route('image.removeImage')}}",data: { 
                    filename: filename,
                    modulename: 'occasions'
                },method : 'post', success: function(result){
                   
                }});
            }
        });
    });
}

//$(document).ready(function(){
//    $('#submit-all').click(function(){
//         myDropzone.processQueue();
//         console.log(this.getQueuedFiles());
//         //$('.dz-preview').removeClass().addClass('dz-preview dz-processing dz-success dz-complete dz-image-preview');
//    });
//
//});



//$('body').delegate('.dz-remove','click',function(){
//        alert($(this).parent().find('.dz-details .dz-filename span').html());
//});


</script>
@endpush