<div class="col-md-4 fadeIn animate-md">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="fa fa-info-circle"></i> &nbsp;Shipping Address Destination
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <p>{!! $PurchaseOrder->shipping_address ?? 'Not Yet Approved' !!}</p>                        
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4 fadeIn animate-md">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="fa fa-info-circle"></i> &nbsp;Remark
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <p>{!! $PurchaseOrder->description ?? 'Not Yet Approved' !!}</p>                        
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4 fadeIn animate-md">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="fa fa-info-circle"></i> &nbsp;Term and Condition
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <p>{!! $PurchaseOrder->term_and_condition ?? 'Not Yet Approved' !!}</p>                        
                </div>
            </div>
        </div>
    </div>
</div>