@extends('layouts.master')
<!-- FooTable -->
{{--<link href="css/plugins/footable/footable.core.css" rel="stylesheet">--}}

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Company'])
        <li class="breadcrumb-item active">
            <a href="/gate/company">Company</a>
        </li>
    @endcomponent
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h4 class="text-center">Companies Data</h4>

                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    @if(Session::has('status'))
                        @component('components.alert', ['type' => 'success'])
                            @slot('message')
                                {{Session::get('status')}}
                            @endslot
                        @endcomponent
                    @endif

                    <input type="text" class="form-control form-control-sm m-b-xs" id="filter"
                           placeholder="Search in table">

                    <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $i=1; @endphp
                        @if($companies == null)
                            @for($i = 0; $i < 20; $i++)
                                <tr class="gradeX">
                                    <td>{{$i}}</td>
                                    <td>MMF</td>
                                    <td>mmf_01</td>
                                    <td>mmf@gmail.com</td>
                                    <td>action link</td>
                                </tr>
                            @endfor
                        @else
                            @foreach($companies as $companyRow)
                                <tr class="gradeX text-center">
                                    <td><?= $i;$i++;?></td>
                                    <td>{{$companyRow->name}}</td>
                                    <td>{{$companyRow->code}}</td>
                                    <td>{{$companyRow->email}}</td>
                                    <td>
                                        <a href="company/{{$companyRow->id}}" class="btn btn-sm btn-outline btn-info pr-1"><i class="fa fa-eye"> View </i></a>
                                        <a href="company/{{$companyRow->id}}/edit" class="btn btn-sm btn-outline btn-primary pr-1"><i class="fa fa-edit"> Edit </i></a>

                                        <form action="company/{{$companyRow->id}}" method="post" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline btn-danger "><i class="fa fa-trash"> Delete </i></button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                        <tfoot>
                            <tr></tr>
                            <tr>
                                <td colspan="6">
                                    <ul class="pagination float-right">
                                        <li class="text-muted">Updated</li>
                                    </ul>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="col-md-4 offset-md-4 center">
                        <a href="{{ route('gate.company.create')}}" class="btn btn-block btn-primary"><strong>Add Company</strong></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
{{--<!-- FooTable -->--}}
{{--<script src="js/plugins/footable/footable.all.min.js"></script>--}}

{{--<!-- Page-Level Scripts -->--}}
{{--<script>--}}
{{--    $(document).ready(function() {--}}

{{--        $('.footable').footable();--}}
{{--        $('.footable2').footable();--}}

{{--    });--}}

{{--</script>--}}
