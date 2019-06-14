@extends('admin.layouts.master')
@section('title')
Edit Products data
@endsection
@section('content')
<div class="page-content">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{url('/')}}">الرئيسية</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <a href="#">تعديل المنتج</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-"></i>بيانات المنتج</div>
                    <div class="tools">
                        <a href="javascript:;" class="reload"> </a>
                        <a href="javascript:;" class="collapse"> </a>
                    </div>
                    <br />
                </div>

                <div class="portlet-body">
                    <form action="{{route('admin.dropzoneStore')}}" enctype="multipart/form-data" class="form-horizontal dropzone dropzone-file-area" id="image-upload"
                          style="border-color:#eee; width: 500px; margin-bottom: 20px; " >
                        {!! csrf_field() !!}
                        <h3>من فضلك ضع الصور هنا !</h3>
                    </form>
                    <form action="{{ route('admin.products.update' , ['id' => $product->id]) }}" onsubmit="return false;" method="post" >
                        {!! csrf_field() !!}
                        <div id="dropzone_image">
                            @foreach($product->getImages() as $img)
                            <input id="image_{{$img->name}}" type="hidden" name="image[]" value="{{$img->name}}" />
                            @endforeach
                        </div>
                        <div class="form-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">اسم المنتج باللغة الإنجليزية</label>
                                    <input type="text" class="form-control" value="{{$product->translated('en')->name}}" name="en_name">
                                </div><!--End Form-group-->
                            </div><!--End Col-md-6-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">اسم المنتج باللغة العربية</label>
                                    <input type="text" class="form-control" value="{{$product->translated('ar')->name}}" name="ar_name">
                                </div><!--End Form-group-->
                            </div><!--End Col-md-6-->

                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">{{ trans('products.category_col') }}</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">{{ trans('products.categories_choose_option') }}</option>
                                        @foreach ($cats as $category)
                                        @php
                                        $arCat = $category->translated('ar');
                                        $enCat = $category->translated('en');
                                        @endphp
                                        <optgroup label="-{{ "$enCat->name | $arCat->name" }}"  class="level-1">

                                            @foreach ($category->subCategories as $sub)
                                            @php
                                            $arSubCat = $sub->translated('ar');
                                            $enSubCat = $sub->translated('en');
                                            @endphp

                                            @if(count($sub->subCategories))
                                        <optgroup label="--{{ "$enSubCat->name | $arSubCat->name" }}" class="level-2">
                                            @foreach ($sub->subCategories as $subsub)
                                            @php
                                            $arSubsubCat = $subsub->translated('ar');
                                            $enSubsubCat = $subsub->translated('en');
                                            @endphp
                                            <option value="{{ $subsub->id }}" @if($subsub->id==$product->category_id) selected @endif class="level-3">{{ "$enSubsubCat->name | $arSubsubCat->name" }}</option>

                                            @endforeach

                                        </optgroup>

                                        @else
                                        <option class="level-2" @if($sub->id==$product->category_id) selected @endif value="{{ $sub->id }}">--{{ "$enSubCat->name | $arSubCat->name" }}</option>
                                        @endif

                                        @endforeach
                                        </optgroup>
                                        @endforeach
                                    </select>
                                </div><!--End Form-group-->
                            </div><!--End Col-md-6-->


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">{{ trans('products.status_col') }}</label>
                                    <select name="active" class="form-control">
                                        <option value="1" @if($product->active == 1) selected @endif>{{ trans('products.active') }}</option>
                                        <option value="0" @if($product->active == 0) selected @endif>{{ trans('products.not_active') }}</option>
                                    </select>
                                </div><!--End Form-group-->
                            </div><!--End Col-md-6-->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">{{ trans('products.price_header') }}</label>
                                    <input class="form-control" value="{{$product->price}}" type="number" min="1" name="price" placeholder="{{ trans('products.price_placeholder') }}" >
                                </div>
                            </div><!--End Col-md-6-->


                            <div class="col-md-6">
                                <div class="form-group">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">{{ trans('products.price_trader_header') }}</label>
                                    <input class="form-control" value="{{$product->price_trader}}" type="number" min="1" name="price_trader" placeholder="{{ trans('products.price_trader_placeholder') }}" >
                                </div><!--End Form-group-->
                            </div><!--End Col-md-6-->


                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="control-label">English Description</label>
                                    <textarea class="form-control tiny-editor">{{$product->translated('en')->description}}</textarea>
                                </div><!--End Form-group-->
                            </div><!--End Col-md-6-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Arabic Description</label>
                                    <textarea class="form-control tiny-editor">{{$product->translated('ar')->description}}</textarea>
                                </div><!--End Form-group-->
                            </div><!--End Col-md-6-->

                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label class="control-label">English Details</label>
                                    <textarea class="form-control tiny-editor">{{$product->translated('en')->details}}</textarea>
                                </div><!--End Form-group-->
                            </div><!--End Col-md-6-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Arabic Details</label>
                                    <textarea class="form-control tiny-editor">{{$product->translated('ar')->details}}</textarea>
                                </div><!--End Form-group-->
                            </div><!--End Col-md-6-->
                            <h3 class="m-b-15">
                                مواصفات المتج :
                            </h3>
                            <div class="mt-repeater">
                                <div data-repeater-list="group">
                                    @php
                                    $fieldsar=json_decode($product->translated('ar')->fields);
                                    $fieldsen=json_decode($product->translated('en')->fields);
                                    @endphp
                                    @foreach($fieldsar as $field)
                                    <div class="row mt-repeater-item" data-repeater-item>
                                        <div class="col-md-5">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">اسم الخاصية بالإنجليزية</label>
                                                        <input value="{{$fieldsen[$loop->index][0]}}" type="text" name="[fieldsen]" class="form-control" placeholder="Enter text">

                                                    </div><!--End Form-gorup-->
                                                </div><!--End Col-md-6-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">الخاصية بالإنجليزية</label>
                                                        <input value="{{$fieldsen[$loop->index][1]}}" type="text" name="[valuesen]" class="form-control" placeholder="Enter text">

                                                    </div><!--End Form-gorup-->
                                                </div><!--End Col-md-6-->
                                            </div><!--End Row-->
                                        </div><!--End Col-md-6-->
                                        <div class="col-md-5">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">اسم الخاصية بالعربية</label>
                                                        <input value="{{$field[0]}}" type="text" name="[fieldsar]" class="form-control" placeholder="Enter text">

                                                    </div><!--End Form-gorup-->
                                                </div><!--End Col-md-6-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">الخاصية بالعربية</label>
                                                        <input value="{{$field[1]}}" type="text" name="[valuesar]" class="form-control" placeholder="Enter text">

                                                    </div><!--End Form-gorup-->
                                                </div><!--End Col-md-6-->
                                            </div><!--End Row-->
                                        </div><!--End Col-md-6-->
                                        <div class="col-md-2">
                                            <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
                                                <i class="fa fa-close"></i> مسح</a>
                                        </div>
                                    </div><!--End Row-->
                                    @endforeach
                                </div><!--End Repeater-list-->
                                <div class="row">
                                    <div class="col-xs-12">
                                        <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add">
                                            <i class="fa fa-plus"></i>
                                            إضافة خاصية جديدة
                                        </a>
                                    </div>
                                </div><!--End Row-->
                            </div>
                            <!--End Row-->
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="text-center">
                                    <button type="submit" class="btn green addBTN">تعديل</button>
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