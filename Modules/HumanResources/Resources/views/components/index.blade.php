<div class="row">
    <div class="col-lg-12">
        <div class="tabs-container">
            <ul class="nav nav-tabs" role="tablist">
                <li><a class="nav-link active" data-toggle="tab" href="#os">Header Structure</a></li>
                <li><a class="nav-link" data-toggle="tab" href="#ost">Title Structure</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" id="os" class="tab-pane active">
                    <div class="panel-body">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4 class="text-center">{{$title}}</h4>

                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-footer">

                                @isset($modals)
                                    {{$modals}}
                                @endisset

                                {{$tableContentOS}}

                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" id="ost" class="tab-pane">
                    <div class="panel-body">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4 class="text-center">{{$title}}</h4>

                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-footer">

                                @isset($modals)
                                    {{$modals}}
                                @endisset

                                {{$tableContentOST}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

