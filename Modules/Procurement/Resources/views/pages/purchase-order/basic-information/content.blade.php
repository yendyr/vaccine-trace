<div class="col-md-4 fadeIn animate-md">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="fa fa-truck"></i> &nbsp;Shipping Address Destination
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    {!! $PurchaseOrder->shipping_address ?? '-' !!}                       
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
                    {!! $PurchaseOrder->description ?? '-' !!}                       
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4 fadeIn animate-md">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="fa fa-question-circle"></i> &nbsp;Term and Condition
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    {!! $PurchaseOrder->term_and_condition ?? '-' !!}                        
                </div>
            </div>
        </div>
    </div>
</div>