@extends('layouts.master')

@section('content')

<div class="passwordBox animated fadeInDown">
    <div class="row">

        <div class="col-md-12">
            <div class="ibox-content">

                <h2 class="font-bold text-center">Execute Job Card</h2>

                <div class="row">
                    <div class="col-lg-12">
                        <form class="m-t" role="inputForm" action="#">
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Scan QR Code here" required="" autofocus>
                            </div>

                            <button type="submit" class="btn btn-primary block full-width m-b hidden">Execute</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr />
</div>


@endsection

@push('header-scripts')
@include('layouts.includes._header-datatable-script')
<style>
    thead input {
        width: 100%;
    }

    tr.group,
    tr.group:hover {
        background-color: #aaa !important;
    }
</style>
@endpush