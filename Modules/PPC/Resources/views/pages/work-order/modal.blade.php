<!-- Modal -->
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="inputForm">
                <div class="modal-body" style="background-color: #eee;">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs">
                                    <li>
                                        <a class="nav-link d-flex align-items-center active" data-toggle="tab" href="#tab-0" style="min-height: 50px;"><i class="text-danger fa fa-asterisk fa-2x fa-fw"></i>&nbsp;Required Basic Data
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-1" style="min-height: 50px;"><i class="text-warning fa fa-external-link fa-2x fa-fw"></i>&nbsp;Optional
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content ">
                                    <div id="tab-0" class="tab-pane active fadeIn" style="animation-duration: 1.5s">
                                        <div class="panel-body">
                                            <div class="row m-b">
                                                <div class="col">
                                                    <label>Work Order Title</label>
                                                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="">
                                                    <div class="invalid-feedback-title text-danger font-italic"></div>
                                                </div>
                                            </div>
                                            <div class="row m-b">
                                                <div class="col">
                                                    <label>Aircraft</label>
                                                    <select class="aircraft_id form-control @error('aircraft_id') is-invalid @enderror" id="aircraft_id" name="aircraft_id"></select>
                                                    <div class="invalid-feedback-aircraft_id text-danger font-italic"></div>
                                                </div>
                                                <div class="col">
                                                    <label>Work Order Number</label>
                                                    <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="Auto generate" readonly>
                                                    <div class="invalid-feedback-code text-danger font-italic"></div>
                                                </div>
                                            </div>
                                            <div class="row m-b">
                                                <div class="col">
                                                    <label>Aircraft Serial Number</label>
                                                    <input type="text" class="form-control @error('aircraft_serial_number') is-invalid @enderror" name="aircraft_serial_number" id="aircraft_serial_number" value="" readonly>
                                                    <div class="invalid-feedback-aircraft_serial_number text-danger font-italic"></div>
                                                </div>
                                                <div class="col">
                                                    <label>Aircraft Register</label>
                                                    <input type="text" class="form-control @error('aircraft_registration_number') is-invalid @enderror" name="aircraft_registration_number" id="aircraft_registration_number" value="" readonly>
                                                    <div class="invalid-feedback-aircraft_registration_number text-danger font-italic"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="tab-1" class="tab-pane fadeIn" style="animation-duration: 1.5s">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col">
                                                    <label>CSN</label>
                                                    <input type="text" class="form-control @error('csn') is-invalid @enderror" name="csn" id="csn">
                                                    <div class="invalid-feedback-csn text-danger font-italic"></div>
                                                </div>
                                                <div class="col">
                                                    <label>CSO</label>
                                                    <input type="text" class="form-control @error('cso') is-invalid @enderror" name="cso" id="cso">
                                                    <div class="invalid-feedback-cso text-danger font-italic"></div>
                                                </div>
                                                <div class="col">
                                                    <label>TSN</label>
                                                    <input type="text" class="form-control @error('tsn') is-invalid @enderror" name="tsn" id="tsn">
                                                    <div class="invalid-feedback-tsn text-danger font-italic"></div>
                                                </div>
                                                <div class="col">
                                                    <label>TSO</label>
                                                    <input type="text" class="form-control @error('tso') is-invalid @enderror" name="tso" id="tso">
                                                    <div class="invalid-feedback-tso text-danger font-italic"></div>
                                                </div>
                                                <div class="col">
                                                    <label>Station</label>
                                                    <input type="text" class="form-control @error('station') is-invalid @enderror" name="station" id="station">
                                                    <div class="invalid-feedback-station text-danger font-italic"></div>
                                                </div>
                                            </div>
                                            <div class="row m-b">
                                                <div class="col">
                                                    <label>Description</label>
                                                    <textarea class="description" name="description" id="description">
                                                        
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="background-color: #fff;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><strong>Close</strong></button>
                    <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveBtn">
                        <strong>Save New</strong>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@push('header-scripts')
<link href="{{ URL::asset('theme/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{URL::asset('theme/css/plugins/summernote/summernote-bs4.min.css')}}" rel="stylesheet">
<style>
    .select2-container.select2-container--default.select2-container--open {
        z-index: 9999999 !important;
    }

    .select2 {
        width: 100% !important;
    }
</style>
@endpush


@push('footer-scripts')
    <script src="{{URL::asset('theme/js/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('.description').summernote();
        });
    </script>
    <script src="{{ URL::asset('theme/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
@endpush