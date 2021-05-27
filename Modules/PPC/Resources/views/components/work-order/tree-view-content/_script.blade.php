@push('footer-scripts')
<script src="{{ URL::asset('theme/js/plugins/jsTree/jstree.min.js') }}"></script>

<script>
$(document).ready(function () {
    $('#tree_view').jstree({
        plugins : ['types'],
        core: {
            "themes": {
                'name': 'proton',
                "responsive": true
            },
            "data": {
                type: "GET",
                url: "/ppc/work-order/"+{{$work_order->id}}+"/work-package/" + {{ $work_package->id }} +"/taskcard/" + {{ $taskcard->id}}+"/tree"
                ,
                success: function (data) {
                    data.d;
                    $(data).each(function () {
                        return { "id": this.id };
                    });
                }
            },            
        },
        types: {
            'default' : {
                'icon' : 'fa fa-folder text-danger'
            },
        }
    });

    $('#tree_view').on('ready.jstree', function() {
        $("#tree_view").jstree("open_all");          
    });
});
</script>
@endpush