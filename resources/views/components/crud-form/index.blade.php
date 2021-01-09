<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title ribbon ribbon-left">
                <div class="ribbon-target" style="top: 6px;">
                    {{ $createButton ?? '' }}
                </div>
                <h4 class="text-center">{{ $title ?? '' }}</h4> 
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="fullscreen-link">
                        <i class="fa fa-expand"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">

                <div class="table-responsive">
                    {{ $tableContent ?? '' }}
                </div>

                {{ $modals ?? '' }}
                
            </div>
        </div>
    </div>
</div>