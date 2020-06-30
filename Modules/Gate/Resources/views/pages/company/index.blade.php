@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Company'])
        <li class="breadcrumb-item active">
            <a href="/gate/company">Company</a>
        </li>
    @endcomponent
@endsection

@section('content')
    @component('gate::components.index', ['title' => 'Companies data'])
        @slot('tableContent')
        <div class="table-responsive">
            <table class="table table-hover dataTables-example">
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
                </tfoot>
            </table>
        </div>
        <div class="col-md-4 offset-md-4 center">
            <a href="{{ route('gate.company.create')}}" class="btn btn-block btn-primary"><strong>Add Company</strong></a>
        </div>
        @endslot
    @endcomponent
@endsection
