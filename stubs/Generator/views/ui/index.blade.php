@extends('sag.layouts.app')
@section('content')
    @include('sag.components.page_header')
    <section class="content">
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                    <tr>
                        <th style="width: 1%">
                            ID
                        </th>
                        <th >
                            Column 1
                        </th>
                        <th >
                            Column 2
                        </th>
                        <th>
                            Column 3
                        </th>
                        <th >
                            Column 4
                        </th>

                    </tr>
                    </thead>
                    <tbody>
                       <tr>
                           <td>1</td>
                           <td>Data column 1</td>
                           <td>Data column 2</td>
                           <td>Data column 3</td>
                           <td>Data colum 4</td>

                       </tr>
                        {{--Binding your data here--}}
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">

            </div>
        </div>
    </section>

@endsection
@push('script')

@endpush
