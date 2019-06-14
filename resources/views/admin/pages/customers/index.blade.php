@extends('admin.layouts.master')
@section('title')
    العملاء
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
                    <span>العملاء</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-newspaper-o"></i>اضافه عميل جديد</div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                            <a href="javascript:;" class="remove"> </a>
                        </div>
                        <br />
                    </div>

                    <div class="portlet-body form">
                        <form  action="{{ route('admin.customers')}}" enctype="multipart/form-data" method="post"  onsubmit="return false;">
                            {!! csrf_field() !!}
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-3 file-box m-b-15">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="display-name">صور الحل</label>
                                        <img class="img-responsive m-b-15 btn-product-image"
                                             style=" width: 130px; height: 130px;display: block; cursor: pointer;" src="https://placeholdit.imgix.net/~text?txtsize=33&txt=290%C3%97180%20or%20larger&w=290&h=180" >
                                        <input type="file" role="button" name="img_name[]" accept="image/*" style="display:none;">
                                        <div class="caption text-center">
                                            <button type="button" class="file-generate btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6 col-md-6">
                                        <label class="col-md-3 control-label">الحلول</label>
                                        <div class="col-md-9 col-sm-6">
                                            <select class="form-control" name="solution_id">
                                                @foreach($solutions as $solution)
                                                    <option value="{{$solution->id}}">{{$solution->arabic()->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6 col-md-6">
                                        <label class="col-md-3 control-label">عنوان الحل باللغه الانجليزيه</label>
                                        <div class="col-md-9 col-sm-6">
                                            <input type="text" class="form-control" name="title_en" placeholder="ادخل عنوان الحل باللغه الانجليزيه">
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-6 col-md-6">
                                        <label class="col-md-3 control-label">عنوان الحل باللغه العربيه</label>
                                        <div class="col-md-9 col-sm-6">
                                            <input type="text" class="form-control" name="title_ar" placeholder="ادخل عنوان الحل باللغه العربيه">
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
                            <i class="fa fa-user"></i>جميع العملاء</div>
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
                                    <th width="25%">الاسم</th>
                                    <th>انشئ منذ</th>
                                    <th>العمليات</th>
                                </tr>
                                </thead>
                                <tbody id="table-body">
                                @foreach($customers as $solution)
                                    <tr>
                                        <td>{{$solution->translated()->title}}</td>
                                        <td>{{$solution->created_at->diffForHumans()}}</td>
                                        <td>
                                            <a href="{{route('admin.customers.edit' ,['id' => $solution->id])}}" class="btn btn-success" >
                                                <i class="fa fa-edit"></i>
                                                تعديل
                                            </a>
                                            <button type="button" class="btn btn-danger btndelet" data-url="{{route('admin.customers.delete' ,['id'=>$solution->id])}}" >
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