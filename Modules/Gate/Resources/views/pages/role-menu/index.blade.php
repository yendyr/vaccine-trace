@extends('layouts.master')

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Role Menu'])
        <li class="breadcrumb-item active">
            <a href="/gate/role-menu">Role Menu</a>
        </li>
    @endcomponent
@endsection

@section('content')
    <div class="form-group row">
        <label class="col-sm-1 col-form-label text-dark">ROLE</label>
        <div class="col-sm-3">
            <select class="select2_role form-control m-b" name="role">
{{--                <option {{ ($roleId == null) ? 'selected' : '' }} disabled>-- selected role --</option>--}}
{{--                @foreach($role as $id => $role_name)--}}
{{--                    <option onclick="setRoleId({{$id}})" {{ ($id == $roleId) ? 'selected' : '' }} value="{{$id}}">{{$role_name}}</option>--}}
{{--                @endforeach--}}
            </select>
        </div>
    </div>
    @component('gate::components.index', ['title' => 'Role Menu Data'])
        @slot('tableContent')
        <div id="form_result" role="alert"></div>

        <div class="table-responsive" id="rolemenu">
            <form id="rolemenu-form">
                @can('create', Modules\Gate\Entities\RoleMenu::class)
                    <div class="form-group row col-sm-12 justify-content-start align-items-start text-center">
                        <div class="col-sm-2">
                            <button class="ladda-button ladda-button-submit btn btn-primary"  data-style="zoom-in" type="submit" id="saveButton">
                                <strong>Save changes</strong>
                            </button>
                        </div>
                    </div>
                @endcan
                <input type="hidden" name="role" value="" id="role-input">
                <table data-ajaxsource="/gate/role-menu" id="rolemenu-table" class="table table-hover text-center">
                    <thead>
                        <tr>
                            <th>Parent Menu</th>
                            <th>Menu Link</th>
                            <th>Menu Text</th>
                            <th>Add</th>
                            <th>Update</th>
                            <th>Delete</th>
                            <th>Print</th>
                            <th>Approval</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr></tr>
                    </tfoot>
                </table>
            </form>

        </div>
        @endslot

    @endcomponent

    @push('footer-scripts')
    <script>
        $(document).ready(function () {
            var tables = $('#rolemenu-table').DataTable({
                serverSide: true,
                paging: false,
                info: false,
                ajax: {
                    url: "{{ route('gate.role-menu.index')}}",
                },
                columns: [
                    { data: 'parent', name: 'parent' },
                    { data: 'menu_link', name: 'menu_link' },
                    { data: 'menu_text', name: 'menu_text' },
                    { data: 'add_column', name: 'add_column', orderable: false },
                    { data: 'update_column', name: 'update_column', orderable: false },
                    { data: 'delete_column', name: 'delete_column', orderable: false },
                    { data: 'print_column', name: 'print_column', orderable: false },
                    { data: 'approval_column', name: 'approval_column', orderable: false },
                ]
            });

            $('.select2_role').select2({
                placeholder: 'choose a role',
                ajax: {
                    url: "{{route('gate.role-menu.select2.role')}}",
                    dataType: 'json',
                }
            });

            $('#saveButton').hide();
            $('.select2_role').on('select2:select', function (e) {
                $('#form_result').empty();
                $('#form_result').removeClass();
                let roleID = $(this).val();
                $('#saveButton').show();
                if ( $.fn.DataTable.isDataTable(tables) ) { //check if isset(tables.Datatable()), destroy it
                    tables.destroy();
                }
                $('#role-input').val(roleID);
                tables = $('#rolemenu-table').DataTable({
                    processing: true,
                    serverSide: true,
                    paging: false,
                    info: false,
                    ajax: {
                        url: "/gate/role-menu/datatable/" + roleID,
                    },
                    columns: [
                        { data: 'parent', name: 'parent' },
                        { data: 'menu_link', name: 'menu_link' },
                        { data: 'menu_text', name: 'menu_text' },
                        { data: 'add_column', name: 'add_column', orderable: false },
                        { data: 'update_column', name: 'update_column', orderable: false },
                        { data: 'delete_column', name: 'delete_column', orderable: false },
                        { data: 'print_column', name: 'print_column', orderable: false },
                        { data: 'approval_column', name: 'approval_column', orderable: false },
                    ]
                });
            });

            $('#rolemenu-form').on('submit', function(event){
                event.preventDefault();
                var action_url = '/gate/role-menu';

                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $(
                            'meta[name="csrf-token"]'
                        ).attr("content")
                    },
                    url: action_url,
                    method:"POST",
                    data:$(this).serialize(),
                    dataType:"json",
                    beforeSend:function(){
                        let l = $( '.ladda-button-submit' ).ladda();
                        l.ladda( 'start' );
                        $('#saveButton'). prop('disabled', true);
                    },
                    error: function(data){
                        if (data.error) {
                            $('#form_result').attr('class', 'alert alert-danger fade show font-weight-bold');
                            $('#form_result').html(data.error);
                        }
                    },
                    success:function(data){
                        if (data.success){
                            $('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                            $('#form_result').html(data.success);
                        }
                    },
                    complete: function () {
                        let l = $( '.ladda-button-submit' ).ladda();
                        l.ladda( 'stop' );
                        $('#rolemenu-table').DataTable().ajax.reload();
                        $('#saveButton'). prop('disabled', false);
                    }
                });
            });
        });

        // function reaction(menuId) {
        //     if($('input[name="index[' + menuId + ']"]').is(":not(:checked)")){
        //         //$('input[name="index[' + menuId + ']"]').attr('value', 0);
        //         $('input[name="add[' + (menuId) + ']"]').prop('checked', false);
        //         // $('input[name="add[' + (menuId) + ']"]').hide();
        //         $('input[name="edit[' + (menuId) + ']"]').prop('checked', false);
        //         // $('input[name="edit[' + (menuId) + ']"]').hide();
        //         $('input[name="delete[' + (menuId) + ']"]').prop('checked', false);
        //         // $('input[name="delete[' + (menuId) + ']"]').hide();
        //     } else{
        //
        //     }
        // }

    </script>
    @endpush

@endsection
