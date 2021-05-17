@extends('layouts.master')

@section('content')

<div class="passwordBox animated fadeInDown">
    <div class="row">

        <div class="col-md-12">
            <div class="ibox-content">

                <h2 class="font-bold text-center">Execute Job Card</h2>

                <div class="row">
                    <div class="col-lg-12">
                        <form class="m-t" role="inputForm" method="POST" action="{{ route('ppc.job-card.execute') }}">
                            @csrf
                            <div class="form-group">
                                <input type="password" name="uuid" id="uuid" class="form-control" placeholder="Scan QR Code here" required="" autofocus>
                            </div>

                            <button type="submit" class="btn btn-primary block full-width m-b">Execute</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr />
</div>

@include('ppc::components.job-card._script')

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