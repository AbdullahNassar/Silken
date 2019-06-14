@extends('admin.layouts.master')
@section('title')
    تعديل السلايد شو
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
                    <span>السلايد شو</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-image"></i>تعديل الصوره</div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                            <a href="javascript:;" class="remove"> </a>
                        </div>
                        <br />
                    </div>

                    <div class="portlet-body form">
                        <form  action="{{ route('admin.sliders.edit' ,['id'=>$slider->id])}}" enctype="multipart/form-data" method="post"  onsubmit="return false;">
                            {!! csrf_field() !!}
                            <div class="form-body">
                                <div class="row" style="margin-left: 50px;">
                                    <div class="form-group col-sm-12 col-md-12 ">
                                        <label class="col-md-3 control-label">الصوره</label>
                                        <div class="col-md-9 col-sm-9 file-box">
                                            <img src="{{asset('storage/uploads/sliders/'.$slider->image)}}" class="img-responsive mr-bot-15 profile-user-img  btn-product-image "
                                                 style="cursor:pointer; height: 150px; width: 150px;">
                                            <input type="file" style="display:none;" name="image">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6 col-md-6">
                                        <label class="col-md-3 control-label">العنوان الاول باللغه العربيه</label>
                                        <div class="col-md-9 col-sm-6">
                                            <input type="text" class="form-control" value="{{$slider->arabic()->title1}}" name="ar_title1" placeholder="ادخل العنوان الاول باللغه العربيه">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 col-md-6">
                                        <label class="col-md-3 control-label">العنوان الاول باللغه الانجليزيه</label>
                                        <div class="col-md-9 col-sm-6">
                                            <input type="text" class="form-control" value="{{$slider->english()->title1}}" name="en_title1" placeholder="ادخل العنوان الاول باللغه الانجليزيه">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6 col-md-6">
                                        <label class="col-md-3 control-label">العنوان الثاني باللغه العربيه</label>
                                        <div class="col-md-9 col-sm-6">
                                            <input type="text" class="form-control" value="{{$slider->arabic()->title2}}" name="ar_title2" placeholder="ادخل العنوان الثاني باللغه العربيه">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 col-md-6">
                                        <label class="col-md-3 control-label">العنوان الثاني باللغه الانجليزيه</label>
                                        <div class="col-md-9 col-sm-6">
                                            <input type="text" class="form-control" value="{{$slider->english()->title2}}" name="en_title2" placeholder="ادخل العنوان الثاني باللغه الانجليزيه">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6 col-md-6">
                                        <label class="col-md-3 control-label">العنوان الثالث باللغه العربيه</label>
                                        <div class="col-md-9 col-sm-6">
                                            <input type="text" class="form-control" value="{{$slider->arabic()->title3}}" name="ar_title3" placeholder="ادخل العنوان الثالث باللغه العربيه">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 col-md-6">
                                        <label class="col-md-3 control-label">العنوان الثالث باللغه الانجليزيه</label>
                                        <div class="col-md-9 col-sm-6">
                                            <input type="text" class="form-control" value="{{$slider->english()->title3}}" name="en_title3" placeholder="ادخل العنوان الثالث باللغه الانجليزيه">
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
        </div>
    </div>    
@endsection