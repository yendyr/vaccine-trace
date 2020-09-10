<div role="tabpanel" id="{{$idPanel}}" class="tab-pane active">
    <div class="ibox ">
        <div class="ibox-title">
            <h4 class="text-center">{{$iboxTitle}}</h4>

            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-footer" id="ibox-{{$ibox}}">
            <div id="form_result" role="alert"></div>
            <div class="col-md-1 m-2 p-1 row">
                {{$addButton}}
            </div>
            <div class="table-responsive">
                {{$tableContent}}
            </div>
        </div>
    </div>
</div>
