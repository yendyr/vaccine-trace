@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'User'])
        <li class="breadcrumb-item active">
            <a href="/gate/user">User</a>
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
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i=1; @endphp
                        @if($users == null)
                            @for($i = 0; $i < 20; $i++)
                                <tr class="gradeX">
                                    <td>{{$i}}</td>
                                    <td>user1</td>
                                    <td>User</td>
                                    <td>user@gmail.com</td>
                                    <td>user role</td>
                                    <td>action link</td>
                                </tr>
                            @endfor
                        @else
                            @foreach($users as $userRow)
                                <tr class="gradeX text-center">
                                    <td><?= $i;$i++;?></td>
                                    <td>{{$userRow->username}}</td>
                                    <td>{{$userRow->name}}</td>
                                    <td>{{$userRow->email}}</td>
                                    <td>{{$userRow->role}}</td>
                                    <td>
                                        <a href="user/{{$userRow->id}}" class="btn btn-sm btn-outline btn-info pr-1"><i class="fa fa-eye"> View </i></a>
                                        <a href="user/{{$userRow->id}}/edit" class="btn btn-sm btn-outline btn-primary pr-1"><i class="fa fa-edit"> Edit </i></a>

                                        <form action="user/{{$userRow->id}}" method="post" class="d-inline">
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
                        <a href="{{ route('gate.user.create')}}" class="btn btn-block btn-primary"><strong>Add User</strong></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
