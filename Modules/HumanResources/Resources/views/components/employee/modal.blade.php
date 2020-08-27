<!-- Modal -->
<div class="modal fade" id="employeeModal" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="employeeForm">
                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fempid">Employee ID</label>
                            <input type="text" class="form-control" id="fempid" name="empid">
                            <div class="invalid-feedback-empid text-danger"></div>
                        </div>
                        <div class="form-group col-sm-1">
                        </div>
                        <div class="form-group col-sm-5">
                            <label class="col-form-label" for="ffullname">Full name</label>
                            <input type="text" class="form-control" id="ffullname" name="fullname" >
                            <div class="invalid-feedback-fullname text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fnickname">Nick Name</label>
                            <input type="text" class="form-control" id="fnickname" name="nickname" >
                            <div class="invalid-feedback-nickname text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-3">
                            <div class="custom-file mt-4">
                                <input id="fphoto" type="file" class="custom-file-input" name="photo">
                                <label for="fphoto" class="custom-file-label">Choose photo</label>
                            </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fpob">Place of birth</label>
                            <input type="text" class="form-control" id="fpob" name="pob">
                            <div class="invalid-feedback-pob text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fdob">Date of birth</label>
                            <input type="date" class="form-control" id="fdob" name="dob">
                            <div class="invalid-feedback-dob text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fgender">Gender</label>
                            <select class="form-control m-b " id="fgender" name="gender">
                                <option value="L">Laki - laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <div class="invalid-feedback-gender text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="freligion">Religion</label>
                            <select class="select2_religion form-control m-b-sm" id="freligion" name="religion">
                            </select>
                            <div class="invalid-feedback-religion text-danger"></div>
                        </div>
                        <div class="form-group col-sm-1">
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fmobile01">Phone 1</label>
                            <input type="text" class="form-control" id="fmobile01" name="mobile01">
                            <div class="invalid-feedback-mobile01 text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fmobile02">Phone 2</label>
                            <input type="text" class="form-control" id="fmobile02" name="mobile02">
                            <div class="invalid-feedback-mobile02 text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="femail">Email</label>
                            <input type="text" class="form-control" id="femail" name="email">
                            <div class="invalid-feedback-email text-danger"></div>
                        </div>
                        <div class="form-group col-sm-1">
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fbloodtype">Blood Type</label>
                            <select class="select2_bloodtype form-control m-b-sm" id="fbloodtype" name="bloodtype">
                            </select>
                            <div class="invalid-feedback-bloodtype text-danger"></div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="fmaritalstatus">Marital Status</label>
                            <select class="select2_maritalstatus form-control m-b-sm" id="fmaritalstatus" name="maritalstatus">
                            </select>
                            <div class="invalid-feedback-maritalstatus text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fempdate">Employee Date</label>
                            <input type="date" class="form-control" id="fempdate" name="empdate">
                            <div class="invalid-feedback-empdate text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fcessdate">Cessation date</label>
                            <input type="date" class="form-control" id="fcessdate" name="cessdate">
                            <div class="invalid-feedback-cessdate text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fprobation">Probation</label>
                            <select class="form-control m-b " id="fprobation" name="probation">
                                <option value="Y">Probation</option>
                                <option value="N">Non Probation</option>
                            </select>
                            <div class="invalid-feedback-probation text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fcesscode">Cessation code</label>
                            <select class="form-control m-b " id="fcesscode" name="cesscode">
                                <option value="01">Resign</option>
                                <option value="02">Retire</option>
                            </select>
                            <div class="invalid-feedback-cesscode text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="frecruitby">Recruit by</label>
                            <select class="select2_recruitby form-control m-b-sm" id="frecruitby" name="recruitby">
                            </select>
                            <div class="invalid-feedback-recruitby text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="femptype">Employee Type</label>
                            <select class="form-control m-b " id="femptype" name="emptype">
                                <option value="01">Permanent</option>
                                <option value="02">Temporary</option>
                            </select>
                            <div class="invalid-feedback-emptype text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fworkgrp">Work group</label>
                            <select class="select2_workgroup form-control m-b-sm" id="fworkgrp" name="workgrp"></select>
                            <div class="invalid-feedback-workgrp text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fsite">Site</label>
                            <input type="text" class="form-control" id="fsite" name="site">
                            <div class="invalid-feedback-site text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="faccsgroup">Access group</label>
                            <input type="text" class="form-control" id="faccsgrp" name="accsgrp">
                            <div class="invalid-feedback-accsgrp text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fachgrp">Achievement group</label>
                            <input type="text" class="form-control" id="fachgrp" name="achgrp">
                            <div class="invalid-feedback-achgrp text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fjobgrp">Job group</label>
                            <input type="text" class="form-control" id="fjobgrp" name="jobgrp">
                            <div class="invalid-feedback-jobgrp text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fcostcode">Cost code</label>
                            <input type="text" class="form-control" id="fcostcode" name="costcode">
                            <div class="invalid-feedback-costcode text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="col-form-label" for="forgcode">Organization code</label>
                            <select class="select2_orgcode form-control m-b-sm" id="forgcode" name="orgcode" onchange="employeeSetOrgcode(this)">
                            </select>
                            <div class="invalid-feedback-orgcode text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="forglvl">Organization level</label>
                            <select class="select2_orglvl form-control m-b-sm" id="forglvl" name="orglvl"></select>
                            <div class="invalid-feedback-orglvl text-danger"></div>
                        </div>
                        <div class="form-group col-sm-2">
                            <label class="col-form-label" for="ftitle">Title</label>
                            <select class="select2_title form-control m-b-sm" id="ftitle" name="title" onchange="employeeSetTitle(this)">
                            </select>
                            <div class="invalid-feedback-title text-danger"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fjobtitle">Job Title</label>
                            <select class="select2_jobtitle form-control m-b-sm" id="fjobtitle" name="jobtitle"></select>
                            <div class="invalid-feedback-jobtitle text-danger"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-8">
                            <label class="col-form-label" for="fremark">Remark</label>
                            <input type="text" class="form-control" id="fremark" name="remark">
                            <div class="invalid-feedback-remark text-danger"></div>
                        </div>
                        <div class="form-group col-sm-1">
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="col-form-label" for="fstatus">Status</label>
                            <select class="form-control m-b " id="fstatus" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <div class="invalid-feedback-status text-danger"></div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><strong>Close</strong></button>
                    <button class="ladda-button ladda-button-submit btn btn-primary"  data-style="zoom-in" type="submit" id="saveBtn">
                        <strong>Save changes</strong>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

