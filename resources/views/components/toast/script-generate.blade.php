@push('footer-scripts')
<script>
    function generateToast (type, data) {
        this.type = type;
        this.data = data;

        $('.notif').removeAttr('class').attr('class', 'notif');

        if (type == "success") {
            $('#notifTitle').html("Success");
            $('#notifMessage').html(data);
            $('.notif').addClass('toast');
            $('.notif').addClass('toast-success');
            $('.notif').addClass('animated');
            $('.notif').addClass('slideInRight');
            $('.notif').toast('show');
        }

        else if (type == "error") {
            $('#notifTitle').html("Error");
            $('#notifMessage').html(data);
            $('.notif').addClass('toast');
            $('.notif').addClass('toast-danger');
            $('.notif').addClass('animated');
            $('.notif').addClass('slideInRight');
            $('.notif').toast('show');
        }
    }
</script>
@endpush