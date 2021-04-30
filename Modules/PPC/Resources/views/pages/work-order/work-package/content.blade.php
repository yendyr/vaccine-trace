<div class="row">
    <div class="col-lg-12">
        <div class="tabs-container">
            <ul class="nav nav-tabs" id="myTab">
                <li>
                    <a class="nav-link d-flex align-items-center active" data-toggle="tab" href="#tab-work-package" style="min-height: 50px;" id="tab-task-card">
                        <i class="fa fa-align-left fa-2x text-warning"></i>&nbsp;Work Package
                    </a>
                </li>
                <li>
                    <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-summary" style="min-height: 50px;" id="tab-maintenance-program">
                        <i class="fa fa-tasks fa-2x text-warning"></i>&nbsp;Work Order Summary
                    </a>
                </li>
                <li>
            </ul>

            <div class="tab-content">
                <div id="tab-work-package" class="tab-pane active">
                    <div class="panel-body" style="min-height: 600px;">
                        <div class="row m-b">
                            <div class="col-md-12 m-t-md fadeIn" style="animation-duration: 1.5s">
                                @component('components.delete-modal', ['name' => 'Work Package Datalist'])
                                @endcomponent

                                @component('components.crud-form.index',[
                                'title' => 'Work Package list on this project',
                                'tableId' => 'work-package-table'])

                                @slot('createButton')
                                @can('update', $work_order)
                                <button type="button" id="create" class="btn btn-primary btn-lg">
                                    <i class="fa fa-plus-circle"></i>&nbsp;Create New Work Package
                                </button>
                                @endcan
                                @endslot

                                @endcomponent

                                @include('ppc::components.work-order.work-package-list._script')
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab-summary" class="tab-pane">
                    <div class="panel-body" style="min-height: 600px;">
                        <div class="row">
                            <div class="col">
                                <div class="ibox">
                                    <div class="ibox-title ribbon ribbon-left">
                                        <div class="ribbon-target" style="top: 6px;">
                                        </div>
                                        <h4 class="text-center">Skill Summary</h4>
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
                                        <table class="table">
                                            <thead>
                                                <th>Skill</th>
                                                <th>Counts</th>
                                            </thead>
                                            <tbody>
                                                @if( !empty($skills) )
                                                @foreach($skills as $skill_name => $skill)
                                                <tr>
                                                    <td>{{ $skill_name ?? '-'}}</td>
                                                    <td>{{ $skill ?? '-'}}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="ibox">
                                    <div class="ibox-title ribbon ribbon-left">
                                        <div class="ribbon-target" style="top: 6px;">
                                        </div>
                                        <h4 class="text-center">Taskcard Counts Summary</h4>
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
                                        <table class="table">
                                            <thead>
                                                <th>Taskcard Group</th>
                                                <th>Counts</th>
                                            </thead>
                                            <tbody>
                                                @if( !empty($taskcard_counts) )
                                                @foreach($taskcard_counts as $taskcard_count_code => $taskcard_count_row)
                                                <tr>
                                                    <td>{{ $taskcard_count_code }} - {{ $taskcard_count_row['name'] ?? '-'}}</td>
                                                    <td>{{ $taskcard_count_row['count'] ?? '-'}}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row m-b">
                            <div class="col-md-12 m-t-md fadeIn" style="animation-duration: 1.5s">
                                @component('components.crud-form.index',[
                                'title' => 'Material and Tools requirements list on this work order',
                                'tableId' => 'work-order-items-table'])
                                @endcomponent

                                @include('ppc::components.work-order._summary_script')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('ppc::pages.work-order.work-package.modal')