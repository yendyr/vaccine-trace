<!-- Modal -->
<div class="modal fade" id="inputModalInstruction" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitleInstruction"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="inputFormInstruction">
                <input type="hidden" id="updateInstruction" name="updateInstruction" class="updateInstruction" value="1">
                <input type="hidden" name="taskcard_id" class="taskcard_id" value="{{ $Taskcard->id }}">
                <input type="hidden" id="id" name="id" class="id">
                <div class="modal-body">

                    <div class="row m-b">    
                        <div class="col">
                            <label>Task Sequence</label>
                            <input type="number" min="1" class="form-control @error('sequence') is-invalid @enderror" name="sequence" id="sequence">
                            <div class="invalid-feedback-sequence text-danger font-italic"></div>
                        </div>   
                        <div class="col">
                            <label>Task Code</label>
                            <input type="text" class="form-control @error('instruction_code') is-invalid @enderror" name="instruction_code" id="instruction_code" required>
                            <div class="invalid-feedback-instruction_code text-danger font-italic"></div>
                        </div>  
                        <div class="col">
                            <label>Parent Instruction</label>
                            <select class="parent_id form-control @error('parent_id') is-invalid @enderror" name="parent_id" id="parent_id">
                            </select>
                            <div class="invalid-feedback-parent_id text-danger font-italic"></div>
                        </div> 
                        <div class="col">
                            <label>Work Area</label>
                            <select class="taskcard_workarea_id form-control @error('taskcard_workarea_id') is-invalid @enderror" name="taskcard_workarea_id" id="taskcard_workarea_id">
                            </select>
                            <div class="invalid-feedback-taskcard_workarea_id text-danger font-italic"></div>
                        </div>                        
                    </div>

                    <div class="row m-b">
                        <div class="col">
                            <label>Skill Requirement</label>
                            <select class="skill_id form-control @error('skill_id') is-invalid @enderror" name="skill_id[]" id="skill_id" multiple="multiple">
                            </select>
                            <div class="invalid-feedback-skill_id text-danger font-italic"></div>
                            <span class="text-info font-italic">
                                <i class="fa fa-info-circle"></i>
                                you can choose multiple value
                            </span>
                        </div>
                        <div class="col">
                            <label>Minimum Authorized Engineering Level</label>
                            <select class="engineering_level_id form-control @error('engineering_level_id') is-invalid @enderror" name="engineering_level_id" id="engineering_level_id">
                            </select>
                            <div class="invalid-feedback-engineering_level_id text-danger font-italic"></div>
                        </div>
                        <div class="col-md-3">
                            <label>Manpower Quantity</label>
                            <input type="number" min="1" class="form-control @error('manpower_quantity') is-invalid @enderror" name="manpower_quantity" id="manpower_quantity">
                            <div class="invalid-feedback-manpower_quantity text-danger font-italic"></div>
                        </div>
                    </div>

                    <div class="row m-b">
                        <div class="col">
                            <label>Manhours Estimation</label>
                            <input type="number" min="0.01" step="0.01" class="form-control @error('manhours_estimation') is-invalid @enderror" name="manhours_estimation" id="manhours_estimation">
                            <div class="invalid-feedback-manhours_estimation text-danger font-italic"></div>
                        </div>
                            <div class="col">
                            <label>Performance Factor</label>
                            <input type="number" min="1" step="0.05" class="form-control @error('performance_factor') is-invalid @enderror" name="performance_factor" id="performance_factor">
                            <div class="invalid-feedback-performance_factor text-danger font-italic"></div>
                        </div>
                        <div class="col">
                            <label>Task Release Level Requirement</label>
                            <select class="task_release_level_id form-control @error('task_release_level_id') is-invalid @enderror" name="task_release_level_id" id="task_release_level_id">
                            </select>
                            <div class="invalid-feedback-task_release_level_id text-danger font-italic"></div>
                        </div>
                    </div>

                    <div class="row m-b">
                        <div class="col">
                            <label>Instruction</label>
                            <textarea class="instruction" name="instruction" id="instruction">
                                
                            </textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><strong>Close</strong></button>
                    <button class="ladda-button ladda-button-submit btn btn-primary" data-style="zoom-in" type="submit" id="saveBtnInstruction">
                        <strong>Save Changes</strong>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@push('header-scripts')
<link href="{{URL::asset('theme/css/plugins/summernote/summernote-bs4.min.css')}}" rel="stylesheet">
@endpush

@push('footer-scripts')
    <script src="{{ URL::asset('theme/js/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.instruction').summernote({ height: 100 });
        });
    </script>
@endpush