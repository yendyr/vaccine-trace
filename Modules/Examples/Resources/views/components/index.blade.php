<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h4 class="text-center">{{$title}}</h4>

                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-footer">
                @if(Session::has('status'))
                    @component('components.alert', ['type' => 'success'])
                        @slot('message')
                            {{Session::get('status')}}
                        @endslot
                    @endcomponent
                @endif

                @isset($modals)
                    {{$modals}}
                @endisset

                {{$tableContent}}

            </div>
        </div>
    </div>
</div>

