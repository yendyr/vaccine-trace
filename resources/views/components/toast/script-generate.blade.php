@push('footer-scripts')
<script>
    function generateToast (type, data) {
        this.type = type;
        this.data = data;

        if (type == "success") {
            $('#notifTitle').html("Success");
            $('#notifMessage').html(data);
            $('.notif').removeClass('toast-danger');
            $('.notif').addClass('toast-success');
            $('.notif').toast('show');
        }

        else if (type == "error") {
            $('#notifTitle').html("Error");
            $('#notifMessage').html(data);
            $('.notif').removeClass('toast-success');
            $('.notif').addClass('toast-danger');
            $('.notif').toast('show');
        }
    }
</script>
@endpush