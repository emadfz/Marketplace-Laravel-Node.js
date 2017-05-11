@extends('admin.layouts.app')
@section('content')
{!! Breadcrumbs::render('category') !!}
<style>        
    /*    #tree { float:left; min-width:319px; border-right:1px solid silver; overflow:auto; padding:0px 0; }
    
    
        .jstree-grid-midwrapper { display: table-row; float: left; margin-top: 45px !important; }
        .jstree-grid-header-cell { padding: 6px 10px 9px !important; }
        .jstree-default .jstree-node {  padding: 5px 0; }
        div.jstree-grid-cell-root-tree { height: 45px; }
        .jstree-grid-cell {padding: 7px 0 8px 7px; }
        .jstree-node, .jstree-children, .jstree-container-ul {padding: 6px 0; }
        .jstree-default .jstree-wholerow { margin-top:5px; }*/

    /*.jstree-default>.jstree-no-dots .jstree-node, .jstree-default>.jstree-no-dots .jstree-leaf>.jstree-ocl{
        height:40px!important;
    }
    .jstree-grid-midwrapper .jstree-grid-column .jstree-grid-cell{
        
        height:40px!important;
    }*/
    #tree li{line-height:40px!important;}
    #tree li .jstree-ocl,#tree li a.jstree-anchor{margin-top:10px!important;}
    .jstree-grid-column-root-tree .jstree-grid-cell.jstree-grid-cell-regular{height:40px!important;padding-top:10px!important;}
    .jstree-default .jstree-wholerow{height:40px!important;}   
    .jstree-grid-header-cell{padding:10px;}
    .jstree-grid-separator{height:100%;}
    /*ul.vakata-context.jstree-contextmenu.jstree-default-contextmenu li:nth-child(5){display:none!important;}*/
    ul.vakata-context.jstree-contextmenu.jstree-default-contextmenu li:nth-child(6){display:none!important;}
    ul.vakata-context.jstree-contextmenu.jstree-default-contextmenu li:nth-child(7){display:none!important;}
    .jstree-grid-cell{height:auto!important;padding-left:34px;}    
    
    
</style>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered" style="min-height:1000px;">
            <div class="portlet-body">


                <div id="container" role="main" >
                    &nbsp;&nbsp;Search : <input type="text" onkeyup="searchNode(this.value)">
                    <div id="tree"></div>
                    <div id="data">
                        <div class="content code" style="display:none;"><textarea id="code" readonly="readonly"></textarea></div>
                        <div class="content folder" style="display:none;"></div>
                        <div class="content image" style="display:none; position:relative;"><img src="" alt="" style="display:block; position:absolute; left:50%; top:50%; padding:0; max-height:90%; max-width:90%;" /></div>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')


<script>
var multipleDelete=0;
    $(function () {
        $(window).resize(function () {
            var h = Math.max($(window).height() - 0, 420);
            $('#container, #data, #tree, #data .content').height(h).filter('.default').css('lineHeight', h + 'px');
        }).resize();
        $('#tree').click(function () {
            $(".make-switch").bootstrapSwitch();
        });


        $('#tree')
                .jstree({
                    'core': {
                        'data': {
                            'url': 'category/getnode',
                            'data': function (node) {
                                return {'id': node.id};
                            }
                        },
                        'check_callback': true,
                        'themes': {
                            'responsive': false
                        }
                    },
                    grid: {
                        columns: [
                            {width: 300, header: "Nodes", title: "_DATA_"},
                            {cellClass: "col1", value: function (node) {

                                    return(node.id != 0 ? node.id : "");
                                }, width: 100, header: "ID", title: "id"},
                            {cellClass: "col2", value: function (node) {
                                    checked = "";
                                    if (node.original.status == "Active") {
                                        checked = "checked";
                                    }
                                    return '<input data-size="small" onchange="makeChange(' + node.id + ')" type="checkbox" class="make-switch" ' + checked + '  data-size="status">';
                                }, width: 200, header: "STATUS", title: "status"},
                            {cellClass: "col3", value: function (node) {
                                    $(".make-switch").bootstrapSwitch();
                                    return(node.original.updated_at ? node.original.updated_at : "");
                                }, width: 200, header: "Last Updated Date", title: "updated_at"},
                            {cellClass: "col4", value: function (node) {
                                    if (node.original.id != 0) {
                                        return '<a href="category/' + node.original.id + '/edit">Edit</a>';
                                    }
                                }, width: 200, header: "Action", title: "action"},
                        ],
                        resizable: true,
                        draggable: true,
                        contextmenu: true,
                        width: 900,
                        height: 900
                    },
                    'force_text': true,
                    "search": {
                        "case_insensitive": true,
                        "ajax": {
                            "url": "category/searchresult"
                        }
                    },
//                     "contextmenu": {
//                             "items": function ($node) {
//                             //var my_tree = $("#tree").jstree(true);
//                                 return {
//                                     "Create": {
//                                         "label": "Create",
//                                         "action": function (obj) {
//                                             //$node = my_tree.create_node($node);
//                                             //my_tree.edit($node);
//                                         }
//                                     },
//                                     "rename_node": {
//                                         "label": "Rename",
//                                         "action": function (obj) {
////                                             window.obj=obj;
//                                             //window.node=$node;
//                                             //my_tree.rename_node($node);
//                                             //this.rename_node($node);
//                                             console.log(tt);
//                                             tt.rename($node);
//                                               
//                                         }
//                                     },
//                                     "Delete": {
//                                         "label": "Delete",
//                                         "action": function (obj) {
//                                             this.remove(obj);
//                                         }
//                                     },
//                                     "edit": {
//                                         "label": "Edit",
//                                         "action": function (obj) {
//                                             this.remove(obj);
//                                         }
//                                     },
//                                     "cut": {
//                                         "label": "Cut",
//                                         "action": function (obj) {
//                                             this.remove(obj);
//                                         }
//                                     },
//                                     "copy": {
//                                         "label": "Copy",
//                                         "action": function (obj) {
//                                             this.remove(obj);
//                                         }
//                                     },
//                                     "paste": {
//                                         "label": "Paste",
//                                         "action": function (obj) {
//                                             this.remove(obj);
//                                         }
//                                     },
//                                 };
//                             }
//                         },
//                    'plugins': ['state', 'dnd', 'contextmenu', 'wholerow', 'search', 'core', 'grid'],
                    'plugins': ['state', 'contextmenu', 'wholerow', 'search', 'core', 'grid'],
                    
//"contextmenu" : {
//    "items" : function ($node) {
//        return {
////            "rename" : {
////                "label" : "Rename",
////                "action" : function (obj) { this.rename(obj); }
////            },
////            "create" : {
////                "label" : "Create",
////                "action" : function (obj) {  this.create_node(obj); }
////            },
////            "delete" : {
////                "label" : "Delete",
////                "action" : function (obj) { this.remove(obj); }
////            },
//             "ccp" : false,
//            "create" : true,
//            "rename" : true,
//            "remove" : true,
//        };
//    }
//},


                })

                .on('delete_node.jstree', function (e, data) {                
                    if(multipleDelete==1){
                        $.get('category/deletenode/' + data.node.id)
                                .done(function (d) {
                                    if (d.status == 'error') {
                                        toastr.error(d.msg);
                                        data.instance.refresh();
                                    } else {
                                        $(".make-switch").bootstrapSwitch();
                                        toastr.success(d.msg);
                                        data.instance.set_id(data.node, d.data.id);
                                    }
                                })
                                .fail(function () {
                                    data.instance.refresh();
                                });
                    }                
                    else if (confirm('Are you sure want to delete?') == true) {
                        multipleDelete=1;
                        $.get('category/deletenode/' + data.node.id)
                                .done(function (d) {
                                    if (d.status == 'error') {
                                        toastr.error(d.msg);
                                        data.instance.refresh();
                                    } else {
                                        $(".make-switch").bootstrapSwitch();
                                        toastr.success(d.msg);
                                        data.instance.set_id(data.node, d.data.id);
                                    }
                                })
                                .fail(function () {
                                    data.instance.refresh();
                                });
                    } else {
                        data.instance.refresh();
                    }
                })
                .on('create_node.jstree', function (e, data) {                    
//                    alert(1);
//            e.preventDefault();
                    return false;
                    $.get('category/createnode', {'id': data.node.parent, 'position': data.position, 'text': data.node.text})
                            .done(function (d) {
                                $(".make-switch").bootstrapSwitch();
                                toastr.success(d.msg);
                                //data.instance.set_id(data.node, d.data.id);
                                //data.instance.refresh();
                            })
                            .fail(function () {
                                data.instance.refresh();
                            });
                })
                .on('rename_node.jstree', function (e, data) {
                    $.get('category/renamenode', {'id': data.node.id, 'parent_id': data.node.parent, 'text': data.text})
                            .done(function (d) {
                                toastr.success(d.msg);
                                $(".make-switch").bootstrapSwitch();
                                data.instance.refresh();
                                //data.instance.set_id(data.node, d.data.id);
                            })
                            .fail(function (result) {
                                toastr.success(JSON.parse(result.responseText).text);
                                data.instance.refresh();
                            });
                })
                .on('move_node.jstree', function (e, data) {
                    $.get('category/movenode/' + data.node.id + '/' + data.parent)
                            .done(function (d) {
                                $(".make-switch").bootstrapSwitch();
                                toastr.success(d.msg);
                                data.instance.set_id(data.node, d.data.id);
                            })
                            .fail(function () {
                                data.instance.refresh();
                            });
                })
                .on('copy_node.jstree', function (e, data) {
                    $.get('category/copynode/' + data.original.id + '/' + data.parent)
                            .done(function (d) {
                                $(".make-switch").bootstrapSwitch();
                                toastr.success(d.msg);
                                data.instance.set_id(data.node, d.data.id);
                            })
                            .always(function () {
                                data.instance.refresh();
                            });
                });
    });

    function searchNode(value) {
        $("#tree").jstree("close_all");
        $("#tree").jstree("search", value);
    }

    function makeChange(id) {

        $.ajax({
            url: 'category/togglestatus/' + id,
            type: 'GET',
            dataType: 'json',
            success: function (r) {
                if (r.success == 1) {
                    toastr.success(r.msg);
                } else if (r.error == 1) {
                    toastr.error(r.msg, "{{ trans('message.failure') }}", {timeOut: 10000});
                }
            },
            error: function (data) {
                if (data.status === 422) {
                    toastr.error("{{ trans('message.failure') }}");
                }
            }
        });
    }
</script>
@endpush