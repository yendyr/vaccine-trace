@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Role'])
        <li class="breadcrumb-item active">
            <a href="/gate/role">Role</a>
        </li>
    @endcomponent
@endsection

@section('content')
    @component('gate::components.index', ['title' => 'Roles data'])
        @slot('tableContent')
            <div class="table-responsive">
                <table class="table table-hover dataTables-example">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Role Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1; @endphp
                        @if($roles == null)
                            @for($i = 0; $i < 20; $i++)
                                <tr class="gradeX">
                                    <td>{{$i}}</td>
                                    <td>role name</td>
                                    <td>action link</td>
                                </tr>
                            @endfor
                        @else
                            @foreach($roles as $roleRow)
                                <tr class="gradeX text-center">
                                    <td><?= $i;$i++;?></td>
                                    <td>{{$roleRow->role_name}}</td>
                                    <td>
                                        <a href="role/{{$roleRow->id}}/edit" class="btn btn-sm btn-outline btn-primary pr-1"><i class="fa fa-edit"> Edit </i></a>

                                        <form action="role/{{$roleRow->id}}" method="post" class="d-inline">
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
                <a href="{{ route('gate.role.create')}}" class="btn btn-block btn-primary"><strong>Add Role</strong></a>
            </div>
        @endslot
    @endcomponent
@endsection
