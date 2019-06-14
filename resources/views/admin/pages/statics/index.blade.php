@extends('admin.layouts.master')
@section('title')
    البيانات الثابته
@endsection
@section('content')
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="{{url('/')}}">الرئيسيه</a>
                    <i class="fa fa-angle-left"></i>
                </li>
                <li>
                    <span>البيانات الثابته</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-info"></i>البيانات الثابته</div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                            <a href="javascript:;" class="remove"> </a>
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered table-stypeed table-responsive">
                                <thead>
                                <tr>
                                    <th>العنوان</th>
                                    <th>انشئ منذ</th>
                                    <th>العمليات</th>
                                </tr>
                                </thead>
                                <tbody id="table-body">
                                @foreach($statics as $static)
                                    <tr>
                                        <td>{{$static->arabic()->title}}</td>
                                        <td>{{$static->created_at->diffForHumans()}}</td>
                                        <td>
                                            <a href="{{route('admin.statics.edit' ,['id' => $static->id])}}" class="btn btn-success" >
                                                <i class="fa fa-edit"></i>
                                                تعديل
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection