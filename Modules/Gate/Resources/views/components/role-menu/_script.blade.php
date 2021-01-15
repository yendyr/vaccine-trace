@push('footer-scripts')
    <script>
        $(document).ready(function () {
            var tables = $('#rolemenu-table').DataTable({
                pageLength: 100,
                processing: true,
                serverSide: false,
                searchDelay: 1500,
                ajax: {
                    url: "{{ route('gate.role-menu.index')}}",
                },
                columns: [
                    { data: 'group', name: 'group' },
                    { data: 'menu_link', name: 'menu_link' },
                    { data: 'menu_text', name: 'menu_text' },
                    { data: 'view_menu', name: 'view_menu' },
                    { data: 'add_column', name: 'add_column', orderable: false },
                    { data: 'update_column', name: 'update_column', orderable: false },
                    { data: 'delete_column', name: 'delete_column', orderable: false },
                    { data: 'print_column', name: 'print_column', orderable: false },
                    { data: 'approval_column', name: 'approval_column', orderable: false },
                ]
            });

            $('.select2_role').select2({
                theme: 'bootstrap4',
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
                    pageLength: 100,
                    processing: true,
                    serverSide: false,
                    searchDelay: 1500,
                    scrollCollapse: true,
                    ajax: {
                        url: "/gate/role-menu/datatable/" + roleID,
                    },
                    columns: [
                        { data: 'group', name: 'group' },
                        { data: 'menu_link', name: 'menu_link' },
                        { data: 'menu_text', name: 'menu_text', className: "text-right" },
                        { data: 'view_menu', name: 'view_menu' },
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
    </script>
@endpush
