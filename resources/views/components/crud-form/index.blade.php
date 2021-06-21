<div id="form_result" role="alert"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title ribbon ribbon-left">
                <div class="ribbon-target" style="top: 6px;">
                    {{ $createButton ?? '' }}
                </div>
                <h4 class="text-center">{{ $title ?? '' }}</h4>
                <div class="ibox-tools">
                    <a class="collapse-link btn btn-icon btn-circle btn-sm btn-danger">
                        <i class="fa fa-chevron-up text-white"></i>
                    </a>
                    <a class="fullscreen-link btn btn-icon btn-circle btn-sm btn-info">
                        <i class="fa fa-expand text-white"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table id="{{ $tableId ?? '' }}" class="table table-hover table-striped text-center" style="width:100%" data-ajaxsource="{{ $ajaxSource ?? '' }}">
                        <thead>
                            {{ $headerSpan ?? '' }}
                            <tr>
                                {{ $tableContent ?? '' }}
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                {{ $tableFooter ?? '' }}
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{ $modals ?? '' }}

            </div>
        </div>
    </div>
</div>
