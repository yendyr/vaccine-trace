<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>{{ $name ?? '' }}</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <a href={{ $href ?? '#' }}>{{ $name ?? '' }}</a>
            </li>
        </ol>
    </div>

    <div class="col-lg-3 d-flex align-items-end flex-row-reverse">
        {{ $slot }}
    </div>
</div>
