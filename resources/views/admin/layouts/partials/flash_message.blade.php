{{--@if (Session::has('flash_message'))
<div class="container">
    <div class="alert alert-{{ Session::get('flash_message_alert_class', 'info') }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ Session::get('flash_message') }}
    </div>
</div>
@endif
--}}

{{--@if (Session::has('flash_notification.message'))
    <div class="alert alert-{{ Session::get('flash_notification.level') }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ Session::get('flash_notification.message') }}
    </div>
@endif--}}

@push('scripts')
<script>
    @if (Session::has('flash_notification.message'))
        @if(Session::get('flash_notification.level') == 'success')
            toastr.success("{{ Session::get('flash_notification.message') }}");
        @elseif (Session::get('flash_notification.level') == 'error' or Session::get('flash_notification.level') == 'danger')
            toastr.error("{{ Session::get('flash_notification.message') }}");
        @elseif (Session::get('flash_notification.level') == 'warning')
            toastr.warning("{{ Session::get('flash_notification.message') }}");
        @else
            toastr.info("{{ Session::get('flash_notification.message') }}");
        @endif
    @endif
    //$("div.alert").delay(5000).slideUp(500);
    //$('#flash-overlay-modal').modal();
</script>
@endpush