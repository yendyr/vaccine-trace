@extends('layouts.master')
<!-- FooTable -->
{{--<link href="css/plugins/footable/footable.core.css" rel="stylesheet">--}}

@section('page-heading')
    @component('components.breadcrumb', ['name' => 'Menu'])
        <li class="breadcrumb-item active">
            <a href="/gate/menu">Menu</a>
        </li>
    @endcomponent
@endsection

@section('content')
    @component('gate::components.index', ['title' => 'Menus data'])
        @slot('tableContent')
        <table class="footable table table-hover" data-page-size="8" data-filter=#filter>
            <thead>
            <tr class="text-center">
                <th>#</th>
                <th>Menu Link</th>
                <th>Parent</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @php $i=1; @endphp
            @if($menus == null)
                @for($i = 0; $i < 20; $i++)
                    <tr class="gradeX">
                        <td>{{$i}}</td>
                        <td>gate/</td>
                        <td>Gate</td>
                        <td>action link</td>
                    </tr>
                @endfor
            @else
                @foreach($menus as $menuRow)
                    <tr class="gradeX text-center">
                        <td><?= $i;$i++;?></td>
                        <td>{{$menuRow->menu_link}}</td>
                        <td>{{$menuRow->parent}}</td>
                        <td>
                            <a href="menu/{{$menuRow->id}}/edit" class="btn btn-sm btn-outline btn-primary pr-1"><i class="fa fa-edit"> Edit </i></a>

                            <form action="menu/{{$menuRow->id}}" method="post" class="d-inline">
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
            <a href="{{ route('gate.menu.create')}}" class="btn btn-block btn-primary"><strong>Add Menu</strong></a>
        </div>
        @endslot
    @endcomponent
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
