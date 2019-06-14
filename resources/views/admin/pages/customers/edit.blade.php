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
                            <i class="fa fa-user"></i>تعديل بيانات العميل </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                            <a href="javascript:;" class="remove"> </a>
                        </div>
                        <br />
                    </div>

                    <div class="portlet-body form">
                        <form  action="{{ route('admin.customers.edit' ,['id'=>$customer->id])}}" enctype="multipart/form-data" method="post"  onsubmit="return false;">
                            {!! csrf_field() !!}
                            <div class="form-body">
                                <div class="row" style="margin-left: 50px;">
                                    @foreach($customer->images as $image)
                                        <div class="col-md-3 col-sm-3 col-xs-12 ajax-target">
                                            <img class="img-responsive mr-bot-15 btn-product-image" alt="user-image" src="{{url('storage/uploads/customers/'.$image->image)}}" style="cursor:pointer; width: 130px; height: 130px;" title="choose image">
                                            <input type="file" style="display:none;" name="imgs[{{$image->id}}}]">
                                            <button type="button" data-url="{{ route('admin.customers.images.delete' ,['solution_id' => $customer->id , 'image_id' => $image->id ]) }}" class="ajax-delete btn btn-warning">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                    <div class="col-md-3 file-box">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="display-name">صور الحل</label>
                                        <img class="img-responsive mr-bot-15 btn-product-image"
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
                                                    <option value="{{$solution->id}}" @if($customer->solution_id == $solution->id){{'selected'}}@endif>{{$solution->arabic()->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6 col-md-6">
                                        <label class="col-md-3 control-label">عنوان الحل باللغه الانجليزيه</label>
                                        <div class="col-md-9 col-sm-6">
                                            <input type="text" class="form-control" name="title_en" value="{{$solution->english()->title}}" placeholder="ادخل عنوان الحل باللغه الانجليزيه">
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-6 col-md-6">
                                        <label class="col-md-3 control-label">عنوان الحل باللغه العربيه</label>
                                        <div class="col-md-9 col-sm-6">
                                            <input type="text" class="form-control" name="title_ar" value="{{$solution->arabic()->title}}" placeholder="ادخل عنوان الحل باللغه العربيه">
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