<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{$meta['title']}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                @if(!empty($meta['breadcrumbs']))
                    <ol class="breadcrumb float-sm-right">
                        @foreach($meta['breadcrumbs'] as $breadcrumb)
                            @if(!empty($breadcrumb['url']))
                                <li class="breadcrumb-item">
                                    <a href="{{$breadcrumb['url']}}">{{$breadcrumb['name']}}</a>
                                </li>
                            @else
                                <li class="breadcrumb-item active">{{$breadcrumb['name']}}</li>
                            @endif
                        @endforeach


                    </ol>
                @endif

            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
