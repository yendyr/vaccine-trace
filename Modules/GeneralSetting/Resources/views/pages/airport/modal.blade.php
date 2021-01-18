<!-- Modal -->
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="inputForm">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Identity</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('identity') is-invalid @enderror" name="identity" id="identity">                            
                                    <div class="invalid-feedback-identity text-danger font-italic"></div>                            
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Type</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('type') is-invalid @enderror" name="type" id="type">
                                    <div class="invalid-feedback-type text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Name</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                                    <div class="invalid-feedback-name text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Latitude</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('latitude') is-invalid @enderror" name="latitude" id="latitude">
                                    <div class="invalid-feedback-latitude text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Longitude</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('longitude') is-invalid @enderror" name="longitude" id="longitude">
                                    <div class="invalid-feedback-longitude text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Elevation</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('elevation') is-invalid @enderror" name="elevation" id="elevation">
                                    <div class="invalid-feedback-elevation text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Continent</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('continent') is-invalid @enderror" name="continent" id="continent">
                                    <div class="invalid-feedback-continent text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">ISO Country</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('iso_country') is-invalid @enderror" name="iso_country" id="iso_country">
                                    <div class="invalid-feedback-iso_country text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">ISO Region</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('iso_region') is-invalid @enderror" name="iso_region" id="iso_region">
                                    <div class="invalid-feedback-iso_region text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Municipality</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control @error('municipality') is-invalid @enderror" name="municipality" id="municipality">
                                    <div class="invalid-feedback-municipality text-danger font-italic"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Scheduled Service</label>
                                <div class="col-sm-7">   
                                    <input type="text" class="form-control @error('scheduled_service') is-invalid @enderror" name="scheduled_service" id="scheduled_service" />
                                    <div class="invalid-feedback-scheduled_service text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">GPS Code</label>
                                <div class="col-sm-7">   
                                    <input type="text" class="form-control @error('gps_code') is-invalid @enderror" name="gps_code" id="gps_code" />
                                    <div class="invalid-feedback-gps_code text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">IATA Code</label>
                                <div class="col-sm-7">   
                                    <input type="text" class="form-control @error('iata_code') is-invalid @enderror" name="iata_code" id="iata_code" />
                                    <div class="invalid-feedback-iata_code text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Local Code</label>
                                <div class="col-sm-7">  
                                    <input type="text" class="form-control @error('local_code') is-invalid @enderror" name="local_code" id="local_code" />
                                    <div class="invalid-feedback-local_code text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Home Link</label>
                                <div class="col-sm-7">   
                                    <input type="text" class="form-control @error('home_link') is-invalid @enderror" name="home_link" id="home_link" />
                                    <div class="invalid-feedback-home_link text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Wikipedia Link</label>
                                <div class="col-sm-7">  
                                    <input type="text" class="form-control @error('wikipedia_link') is-invalid @enderror" name="wikipedia_link" id="wikipedia_link" />
                                    <div class="invalid-feedback-wikipedia_link text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Keywords</label>
                                <div class="col-sm-7">   
                                    <input type="text" class="form-control @error('keywords') is-invalid @enderror" name="keywords" id="keywords" />
                                    <div class="invalid-feedback-keywords text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Description</label>
                                <div class="col-sm-7">  
                                    <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" />
                                    <div class="invalid-feedback-description text-danger font-italic"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 d-flex align-items-center">Active</label>
                                <div class="col-sm-7">     
                                    <div class="pretty p-icon p-round p-jelly p-bigger" style="font-size: 15pt;">   
                                        <input type="checkbox" class="form-control @error('status') is-invalid @enderror" name="status" id="status" />
                                        <div class="state p-primary">
                                            <i class="icon fa fa-check"></i>
                                            <label></label>
                                        </div>
                                        <div class="invalid-feedback-status text-danger font-italic"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><strong>Close</strong></button>
                    <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveBtn">
                        <strong>Save Changes</strong>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>