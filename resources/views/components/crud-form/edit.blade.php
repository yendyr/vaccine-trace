<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Edit {{$name}}</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="fullscreen-link">
                        <i class="fa fa-expand"></i>
                    </a>
                    {{-- <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a> --}}
                </div>
            </div>
                               
            <div class="ibox-content">
                <form method="post" action="{{ $action }}{{ $row->id }}">
                @method('patch')
                @csrf
                <!-- CSRF untuk keamanan -->                 
                {{ $formEdit }}

                <div class="hr-line-dashed m-b-lg"></div>
                <div class="form-group row justify-content-center">
                    <button class="btn btn-primary btn-lg m-xs" type="submit">Save Changes</button>
                </div>                
                </form>
            </div>            
        </div>
    </div>
</div>