<div class="col-md-12 m-t-md fadeIn" style="animation-duration: 1.5s">
    <form method="post" id="inputFormDetail">
        
        <div class="row">
            <select class="aircraft_type_id form-control @error('aircraft_type_id') is-invalid @enderror" name="aircraft_type_id" id="aircraft_type_id"></select>
            <div class="invalid-feedback-aircraft_type_id text-danger font-italic"></div>
        </div>    

        <div class="modal-footer row">
            <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveBtn">
                <strong>Save Changes</strong>
            </button>
        </div>

    </form>
</div>

@include('ppc::components.maintenance-program.taskcard-list._script')
@push('header-scripts')
    <link href="{{ URL::asset('theme/css/plugins/dualListbox/bootstrap-duallistbox.min.css') }}" rel="stylesheet">
@endpush