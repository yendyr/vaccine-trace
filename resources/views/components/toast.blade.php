<div class="toast toast-bootstrap show bg-{{ $color }}" id="notif" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <i class="fa fa-newspaper-o"> </i>
        <strong class="mr-auto m-l-sm">Notification</strong>
        <small>2 seconds ago</small>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="toast-body">
        {{ $message }}
    </div>
</div>