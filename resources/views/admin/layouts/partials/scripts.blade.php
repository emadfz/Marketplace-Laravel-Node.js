<script>
var assetsPath="{{ asset('') }}"
</script>
<!--[if lt IE 9]>
<script src="{{ asset('assets/admin/global/plugins/respond.min.js') }}"></script>
<script src="{{ asset('assets/admin/global/plugins/excanvas.min.js') }}"></script> 
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{ asset('assets/admin/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ asset('assets/admin/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/admin/global/plugins/jquery.form.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- Start: DataTable -->
<!--<script src="{{ asset('assets/admin/dev/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/admin/dev/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/admin/dev/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/admin/dev/datatables/buttons.server-side.js') }}"></script>-->

<script src="{{ asset('assets/admin/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/jstree/dist/jstree.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/plugins/jstree/dist/jstreegrid.js') }}" type="text/javascript"></script>

<!-- End: DataTable -->
<script src="{{ asset('assets/admin/global/plugins/jquery-notific8/jquery.notific8.min.js')}}" type="text/javascript"></script>
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ asset('assets/admin/global/scripts/app.min.js') }}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->

<script src="{{ asset('assets/admin/pages/scripts/ui-notific8.min.js') }}" type="text/javascript"></script>

<!--<script src="{{ asset('assets/admin/pages/scripts/table-datatables-managed.min.js') }}" type="text/javascript"></script>-->
<!--<script src="{{ asset('assets/admin/dev/datatables/buttons.server-side.js') }}"></script>-->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{ asset('assets/admin/layouts/layout4/scripts/layout.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/layouts/layout4/scripts/demo.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->

<script src="{{ asset('assets/admin/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/scripts/project.app.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/global/scripts/socket.js') }}" type="text/javascript"></script>
<script>
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-full-width",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "2000",
    "hideDuration": "1000",
    "timeOut": "5000", // How long the toast will display without user interaction
    "extendedTimeOut": "3000", // How long the toast will display after a user hovers over it
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}
</script>


