
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Add Company Form</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <form method="post" action="{{$action}}">
                @csrf
                <!-- CSRF untuk keamanan -->
                <div class="form-group row"><label class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name')}}">
                        @error('name')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row"><label class="col-sm-2 col-form-label">Code</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code')}}">
                        @error('code')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row"><label class="col-sm-2 col-form-label">Email @if(isset($message)) {{$message}} @endif</label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email')}}">
                        @error('email')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row"><label class="col-sm-2 col-form-label">Remark</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control @error('remark') is-invalid @enderror" name="remark" value="{{ old('remark')}}">
                        @error('remark')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-white btn-md" type="reset">Reset</button>
                        <button class="btn btn-primary btn-md" type="submit">Save changes</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
