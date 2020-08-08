
    <script>
        var treeGridObj;    //var for TreeGRidObj

        function reloadOs(){
            ej.treegrid.TreeGrid.Inject(ej.treegrid.Toolbar, ej.treegrid.Sort, ej.treegrid.Filter,  ej.treegrid.CommandColumn);
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $(
                        'meta[name="csrf-token"]'
                    ).attr("content")
                },
                url: "/hr/org-structure/json",
                method: "GET",
                dataType: 'json',
                beforeSend: function(){
                    $('#TreeGrid').empty();
                },
                success:function(data){
                    treeGridObj = new ej.treegrid.TreeGrid({
                        dataSource: data.result,
                        childMapping: 'childs',
                        toolbar: ['Search'],
                        allowSorting: true,
                        searchSettings: { fields: ['orgcode', 'orgname', 'orglevel']},
                        treeColumnIndex: 1,
                        columns: [
                            { field: 'id', headerText: 'ID', isPrimaryKey: true, width: 45, textAlign: 'Center', visible: false},
                            { field: 'orgcode', headerText: 'Org. Structure Code', width: 120, textAlign: 'Left'},
                            { field: 'orgparent', headerText: 'Org. Structure Parent', width: 120, textAlign: 'Left', visible: false},
                            { field: 'orgname', headerText: 'Org. Structure Name', width: 180, textAlign: 'Left'},
                            // { field: 'startDate', headerText: 'Start Date', width: 90, textAlign: 'Left', editType: 'datepickeredit', type: 'date', format: 'yMd', allowSorting: false },
                            { field: 'orglevel', headerText: 'Org. Structure Level', width: 120, textAlign: 'Left',
                                allowSorting: false, disableHtmlEncode: false, valueAccessor: getLevel },
                            { field: 'status', headerText: 'Status', width: 80, textAlign: 'Left', allowSorting: false,
                                disableHtmlEncode: false, valueAccessor: getStatus },
                            @can('update', \Modules\HumanResources\Entities\OrganizationStructure::class)
                            { headerText: 'Action', width: 80, disableHtmlEncode: false,
                                commands: [
                                    { type: 'Update', buttonOption: { iconCss: ' e-icons e-edit', click: onUpdate } }
                                ]
                            },
                            @endcan
                        ],
                        height: 270,
                        actionBegin: function(args){
                            if (args.requestType === 'save') {
                            }
                        },
                        actionComplete: function(args){
                            if (args.requestType === 'beginEdit') {
                            }
                            if (args.requestType === 'add') {
                            }
                        },
                    });
                    treeGridObj.appendTo('#TreeGrid');
                },
                error:function(data){
                    let errors = data.responseJSON.errors;
                    $("#ibox_os").find('#form_result').attr('class', 'alert alert-danger fade show font-weight-bold');
                    $("#ibox_os").find('#form_result').html('Some error occured while loading the data. Please reload this page!');
                }
            });
        }

        function getStatus(field, data, column){
            if (data.status == 1){
                return '<p class="text-success">Active</p>';
            } else if(data.status == 0){
                return '<p class="text-danger">Inactive</p>';
            }
        }

        function getLevel(field, data, column){
            if (data.orglevel == 1){
                return 'Direksi';
            } else if(data.orglevel == 2){
                return 'General';
            } else if(data.orglevel == 3){
                return 'Divisi';
            } else if(data.orglevel == 4){
                return 'Bagian';
            } else if(data.orglevel == 5){
                return 'Seksi';
            } else if(data.orglevel == 6){
                return 'Regu';
            } else if(data.orglevel == 7){
                return 'Group';
            }
        }

        function onUpdate(args){
            let rowIndex = ej.base.closest(args.target, '.e-row').rowIndex;
            let dataRow = treeGridObj.getCurrentViewRecords();

            $('#osForm').trigger("reset");
            $("#osModal").find('#modalTitle').html("Update Organization Structure data");
            $('#saveBtn').val("edit-os");
            $('#osForm').attr('action', '/hr/org-structure/' + dataRow[rowIndex]['id']);

            $('#forglevel').find('option').removeAttr('selected');
            $('#forglevel').find('option[value="' + dataRow[rowIndex]['orglevel'] + '"]').attr('selected', '');

            $('#forgname').val(dataRow[rowIndex]['orgname']);

            $("#osForm").find('#forgcode').val(dataRow[rowIndex]['orgcode']);

            $(".select2_orgparent").select2("val", "none");
            if (dataRow[rowIndex]['orgparent'] == null){
                $('#forgparent').append('<option value="' + 0 + '" selected>none</option>');
            } else{
                $('#forgparent').append('<option value="' + dataRow[rowIndex]['orgparent'] + '" selected>' + dataRow[rowIndex]['orgparent'] + '</option>')
            }

            $("#osForm").find('#fstatus').find('option').removeAttr('selected');
            $("#osForm").find('#fstatus').find('option[value="' + dataRow[rowIndex]['status'] + '"]').attr('selected', '');

            $('<input type="hidden" name="_method" value="patch">').prependTo('#osForm');
            $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
            $('#osModal').modal('show');
        }

        $(document).ready(function () {
            reloadOs();

            $('.select2_orgparent').select2({
                placeholder: 'choose here',
                ajax: {
                    url: "{{route('hr.org-structure.select2.orgcode')}}",
                    dataType: 'json',
                },
                dropdownParent: $('#osForm')
            });

            $('#createOS').click(function () {
                $('#saveBtn').val("create-os");
                $("#osForm").trigger('reset');
                $("#osModal").find('#modalTitle').html("Add New Organization Structure data");
                $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
                $(".select2_orgparent").select2("val", "none");

                $('#osModal').modal('show');
                $('#osForm').attr('action', '/hr/org-structure');
                $("input[value='patch']").remove();
            });

            $('#osForm').on('submit', function (event) {
                event.preventDefault();
                let url_action = $(this).attr('action');
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $(
                            'meta[name="csrf-token"]'
                        ).attr("content")
                    },
                    url: url_action,
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: 'json',
                    beforeSend:function(){
                        $('[class^="invalid-feedback-"]').html('');
                        $("#osForm").find('#saveBtn').html('<strong>Saving...</strong>');
                        $("#osForm").find('#saveBtn').prop('disabled', true);
                    },
                    success:function(data){
                        if (data.success) {
                            $("#ibox-os").find('#form_result').attr('class', 'alert alert-success fade show font-weight-bold');
                            $("#ibox-os").find('#form_result').html(data.success);
                        }
                        $('#osModal').modal('hide');
                        reloadOs();
                    },
                    error:function(data){
                        let errors = data.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function (index, value) {
                                $('div.invalid-feedback-'+index).html(value);
                            })
                        }
                    },
                    complete:function(){
                        $("#osForm").find('#saveBtn').prop('disabled', false);
                        $("#osForm").find('#saveBtn').html('<strong>Save Changes</strong>');
                    }
                });
            });
        });

    </script>
