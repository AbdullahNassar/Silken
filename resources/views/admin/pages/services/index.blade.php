@extends('admin.layouts.master')
@section('title')
    الخدمات
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
                    <span>الخدمات</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-list"></i>اضافه خدمه جديده</div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                            <a href="javascript:;" class="remove"> </a>
                        </div>
                        <br />
                    </div>

                    <div class="portlet-body form">
                        <form  action="{{ route('admin.services') }}" enctype="multipart/form-data" method="post"  onsubmit="return false;">
                            {!! csrf_field() !!}
                            <div class="form-body">
                                <div class="row" style="margin-left: 50px;">
                                    <div class="form-group col-sm-12 col-md-12 ">
                                        <label class="col-md-3 control-label">صوره الخدمه</label>
                                        <div class="col-md-9 col-sm-9 file-box">
                                            <img src="http://knowledge-commons.com/static/assets/images/avatar.png" class="img-responsive mr-bot-15 profile-user-img btn-product-image"
                                                 style="cursor:pointer; height: 150px; width: 150px;">
                                            <input type="file" style="display:none;" name="image">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6 col-md-6">
                                        <label class="col-md-3 control-label">عنوان الخدمه باللغه العربيه</label>
                                        <div class="col-md-9 col-sm-6">
                                            <input type="text" class="form-control" name="ar_title" placeholder="ادخل عنوان الخدمه باللغه العربيه">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 col-md-6">
                                        <label class="col-md-3 control-label">عنوان الخدمه باللغه الانجليزيه</label>
                                        <div class="col-md-9 col-sm-6">
                                            <input type="text" class="form-control" name="en_title" placeholder="ادخل عنوان الخدمه باللغه الانجليزيه">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6 col-md-6">
                                        <label class="col-md-3 control-label">محتوي الخدمه باللغه العربيه</label>
                                        <div class="col-md-9 col-sm-6">
                                            <textarea class="form-control tiny-editor" placeholder="ادخل محتوي الخدمه باللغه العربيه"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 col-md-6">
                                        <label class="col-md-3 control-label">محتوي الخدمه باللغه الانجليزيه</label>
                                        <div class="col-md-9 col-sm-6">
                                            <textarea class="form-control tiny-editor" placeholder="ادخل محتوي الخدمه باللغه الانجليزيه"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="text-center ">
                                        <button type="submit" class="btn  green addBTN">حفظ
                                            <i class="fa fa-save"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!--End portlet-->
            </div>
            <div class="col-md-12">
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-list"></i>جميع الخدمات</div>
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
                                    <th>الصوره</th>
                                    <th width="25%">الاسم</th>
                                    <th width="25%">الوصف</th>
                                    <th>انشئ منذ</th>
                                    <th>العمليات</th>
                                </tr>
                                </thead>
                                <tbody id="table-body">
                                @foreach($services as $service)
                                    <tr>
                                        <td><img src="{{asset('storage/uploads/services/'.$service->image)}}" height="150px;" width="150p;"></td>
                                        <td>{{$service->translated()->title}}</td>
                                        <td>{!! str_limit($service->translated()->description ,100) !!}</td>
                                        <td>{{$service->created_at->diffForHumans()}}</td>
                                        <td>
                                            <a href="{{route('admin.services.edit' ,['id' => $service->id])}}" class="btn btn-success" >
                                                <i class="fa fa-edit"></i>
                                                تعديل
                                            </a>
                                            <button type="button" class="btn btn-danger btndelet" data-url="{{route('admin.services.delete' ,['id'=>$service->id])}}" >
                                                <i class="fa fa-trash"></i>
                                                مسح
                                            </button>
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