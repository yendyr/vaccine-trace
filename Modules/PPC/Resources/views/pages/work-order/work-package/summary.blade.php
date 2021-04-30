<div class="col-md-12 m-t-md fadeIn" style="animation-duration: 1.5s">
    <div id="form_result" role="alert"></div>
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
                                'title' => 'Material and Tools requirements list on this work package',
                                'tableId' => 'work-package-items-table'])
                @endcomponent

            @include('ppc::components.work-order.work-package-list._summary_script')
        </div>
    </div>
</div>