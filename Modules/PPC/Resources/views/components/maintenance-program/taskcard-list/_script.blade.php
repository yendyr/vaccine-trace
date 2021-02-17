@push('footer-scripts')
<script src="{{ URL::asset('theme/js/plugins/dualListbox/jquery.transfer.js') }}"></script>

<script>
$(document).ready(function () {
    // $('#tree_view').jstree({
    //     plugins : ['types'],
    //     core: {
    //         "themes": {
    //             'name': 'proton',
    //             "responsive": true
    //         },
    //         "data": {
    //             type: "GET",
    //             url: "/ppc/aircraft-configuration-template/detail-tree/?id=" + $('#aircraft_configuration_template_id').val(),
    //             success: function (data) {
    //                 data.d;
    //                 $(data).each(function () {
    //                     return { "id": this.id };
    //                 });
    //             }
    //         },            
    //     },
    //     types: {
    //         'default' : {
    //             'icon' : 'fa fa-folder text-danger'
    //         },
    //     }
    // });

    // var groupDataArray1 = [
    //     {
    //         "groupName": "China",
    //         "groupData": [
    //             {
    //                 "taskcard": "Beijing",
    //                 "id": 122
    //             },
    //             {
    //                 "taskcard": "Shanghai",
    //                 "id": 643
    //             },
    //             {
    //                 "taskcard": "Qingdao",
    //                 "id": 422
    //             },
    //             {
    //                 "taskcard": "Tianjin",
    //                 "id": 622
    //             }
    //         ]
    //     },
    //     {
    //         "groupName": "Japan",
    //         "groupData": [
    //             {
    //                 "taskcard": "Tokyo",
    //                 "id": 132
    //             },
    //             {
    //                 "taskcard": "Osaka",
    //                 "id": 112
    //             },
    //             {
    //                 "taskcard": "Yokohama",
    //                 "id": 191
    //             }
    //         ]
    //     }
    // ];

    var master_taskcards = [];

    $.ajax({
        url: "/ppc/taskcard/list-tree",
        async: false,
        dataType: 'json',
        success: function(data) {
            master_taskcards = data;
        }
    });

    var duallistbox = {
        // "groupDataArray": groupDataArray1,
        // "groupItemName": "groupName",
        // "groupArrayName": "groupData",
        'dataArray': master_taskcards,
        'itemName': "taskcard",
        'valueName': "id",
        'tabNameText': "Available Master Task Card",
        'rightTabNameText': "Selected Task Card",
        'searchPlaceholderText': "Search",
        'callable': function (items) {
            console.dir(items)
        }
    };

    $("#taskcard-list-box").transfer(duallistbox);
    $("[id*=ListSearch]").addClass('form-control');
    $("[id*=listSearch]").addClass('form-control');
});
</script>
@endpush