@extends('admin.layouts.master')
@section('title')
Edit Main Categories data
@endsection
@section('content')
<div class="page-content">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{url('/')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">Edit Main Categories Data</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list-ol"></i>Edit Main Categories data</div>
                    <div class="tools">
                        <a href="javascript:;" class="reload"> </a>
                        <a href="javascript:;" class="collapse"> </a>
                    </div>
                    <br />
                </div>

                <div class="portlet-body form">
                    <form action="{{ route('admin.categories.edit' , ['id' => $cat->id , 'type' => 'sub'])}}" onsubmit="return false;" method="post" >
                        {!! csrf_field() !!}
                        @php
                        $en = $cat->translated('en');
                        $ar = $cat->translated('ar');
                        @endphp
                        <div class="form-body row">
                            <div class="form-group col-sm-6 col-md-6">
                                <label class="col-md-3 control-label">Category Name (In English)</label>
                                <div class="col-md-9 col-sm-6">
                                    <input type="text" class="form-control" value="{{ $en->name }}" name="en_name" placeholder="Enter title">
                                </div>
                            </div>
                            <div class="form-group col-sm-6 col-md-6">
                                <label class="col-md-3 control-label">Category Name (In Arabic)</label>
                                <div class="col-md-9 col-sm-6">
                                    <input type="text" class="form-control" value="{{ $ar->name }}" name="ar_name" placeholder="Enter Content">
                                </div>
                            </div>

                            <div class="form-group col-md-6 col-sm-6 ">
                                <label class="col-md-3 control-label">Category Status</label>
                                <div class="col-md-9 col-sm-6">
                                    <select class="form-control" name="active">
                                        <option value="1" {{ $cat->active? 'selected' : '' }}>Active | فعال</option>
                                        <option value="0" {{ !$cat->active? 'selected' : '' }}>Not Active | غير فعال</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 ">
                                <label class="col-md-3 control-label">Category Status</label>
                                <div class="col-md-9 col-sm-6">
                                    <select class="form-control" name="parent_id">
                                        <option value="">{{ trans('products.categories_choose_option') }}</option>
                                        @foreach ($categories['main'] as $category)
                                        @php
                                        $arCat = $category->translated('ar');
                                        $enCat = $category->translated('en');
                                        @endphp
                                        <optgroup label="{{ "$enCat->name | $arCat->name" }}">
                                            @foreach ($category->subCategories as $sub)
                                            @php
                                            $arSubCat = $sub->translated('ar');
                                            $enSubCat = $sub->translated('en');
                                            @endphp
                                            <option <?php if($cat->parent_id==$sub->id) echo 'selected'; ?>  value="{{ $sub->id }}">{{ "$enSubCat->name | $arSubCat->name" }}</option>
                                            @endforeach
                                        </optgroup>
                                        @endforeach
                                        @if (!empty($categories['other']))
                                        <optgroup label="{{ trans('products.sub_categories_header') }}">
                                            @foreach ($categories['other'] as $category)
                                            @php
                                            $arCat = $category->translated('ar');
                                            $enCat = $category->translated('en');
                                            @endphp
                                            <option   value="{{ $category->id }}">{{ "$enCat->name | $arCat->name" }}</option>
                                            @endforeach
                                        </optgroup>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="text-center">
                                    <button type="submit" class="btn green addBTN">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!--End portlet-->
            </div>
        </div>
    </div>
</div>
@endsection