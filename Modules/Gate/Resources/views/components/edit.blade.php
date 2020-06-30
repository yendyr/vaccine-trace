
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Edit {{$name}} Form</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-footer">
                <form method="post" action="{{$action}}{{$row->id}}">
                @method('patch')
                @csrf
                <!-- CSRF untuk keamanan -->

                {{$formEdit}}

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <div class="col-md-4 col-sm-offset-2">
                        <button class="btn btn-primary btn-md" type="submit">Save changes</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
