@extends('admin.layouts.master')
@section('title')
Products data
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
                <a href="#">المنتجات</a>
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
                    <form action="{{ route('admin.products.add') }}" onsubmit="return false;" method="post" >
                        {!! csrf_field() !!}
                        <div id="dropzone_image"></div>
                        <div class="form-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">اسم المنتج باللغة الإنجليزية</label>
                                    <input type="text" class="form-control" name="en_name">
                                </div><!--End Form-group-->
                            </div><!--End Col-md-6-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">اسم المنتج باللغة العربية</label>
                                    <input type="text" class="form-control" name="ar_name">
                                </div><!--End Form-group-->
                            </div><!--End Col-md-6-->
                            <!--
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">{{ trans('products.price_header') }}</label>
                                                                <input class="form-control" type="number" min="1" name="price" placeholder="{{ trans('products.price_placeholder') }}" >
                                                            </div>End Form-group--
                                                        </div>End Col-md-6--
                            -->

                            


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
                                            <option value="{{ $subsub->id }}" class="level-3">{{ "$enSubsubCat->name | $arSubsubCat->name" }}</option>

                                            @endforeach

                                        </optgroup>

                                        @else
                                        <option class="level-2" value="{{ $sub->id }}">--{{ "$enSubCat->name | $arSubCat->name" }}</option>
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
                                        <option value="">{{ trans('products.status_choose_option') }}</option>
                                        <option value="1">{{ trans('products.active') }}</option>
                                        <option value="0">{{ trans('products.not_active') }}</option>
                                    </select>
                                </div><!--End Form-group-->
                            </div><!--End Col-md-6-->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">{{ trans('products.price_header') }}</label>
                                    <input class="form-control" type="number" min="1" name="price">
                                </div><!--End Form-group-->
                            </div><!--End Col-md-6-->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">{{ trans('products.price_trader_header') }}</label>
                                    <input class="form-control" type="number" min="1" name="price_trader" >
                                </div><!--End Form-group-->
                            </div><!--End Col-md-6-->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">وصف المنتج بالانجليزية</label>
                                    <textarea class="form-control tiny-editor"></textarea>
                                </div><!--End form-group-->
                            </div><!--End Col-md-6-->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">وصف المنتج بالعربية</label>
                                    <textarea class="form-control tiny-editor"></textarea>
                                </div>
                            </div><!--End Col-md-6-->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">تفاصيل المنتج بالإنجليزية</label>
                                    <textarea class="form-control tiny-editor"></textarea>
                                </div><!--End form-group-->
                            </div><!--End Col-md-6-->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">تفاصيل المنتج بالعربية</label>
                                    <textarea class="form-control tiny-editor"></textarea>
                                </div><!--End form-group-->
                            </div><!--End Col-md-6-->
                            <h3 class="m-b-15">
                                مواصفات المتج :
                            </h3>
                            <div class="mt-repeater">
                                <div data-repeater-list="group">
                                    <div class="row mt-repeater-item" data-repeater-item>
                                        <div class="col-md-5">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">اسم الخاصية بالإنجليزية</label>
                                                        <input  type="text" name="[fieldsen]" class="form-control">
                                                    </div><!--End Form-gorup-->
                                                </div><!--End Col-md-6-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">الخاصية بالإنجليزية</label>
                                                        <input  type="text" name="[valuesen]" class="form-control">
                                                    </div><!--End Form-gorup-->
                                                </div><!--End Col-md-6-->
                                            </div><!--End Row-->
                                        </div><!--End Col-md-6-->
                                        <div class="col-md-5">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">اسم الخاصية بالعربية</label>
                                                        <input  type="text" name="[fieldsar]" class="form-control">
                                                    </div><!--End Form-gorup-->
                                                </div><!--End Col-md-6-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">الخاصية بالعربية</label>
                                                        <input  type="text" name="[valuesar]" class="form-control">
                                                    </div><!--End Form-gorup-->
                                                </div><!--End Col-md-6-->
                                            </div><!--End Row-->
                                        </div><!--End Col-md-6-->
                                        <div class="col-md-2">
                                            <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
                                                <i class="fa fa-close"></i> مسح</a>
                                        </div>
                                    </div><!--End Row-->

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
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="font-dark"></i>
                        <span class="caption-subject bold uppercase">جميع المنتجات</span>
                    </div>
                </div>
                <form action="{{ url('admin/products/') }}" onsubmit="return false;">
                    <div class="box-body" >
                        <div class="margin-bottom row">
                            <div class="row top-table">
                                <div class=" col-md-8 col-sm-8">
                                    <div class="col-md-9 col-xs-9">
                                        <div class="btn-group" data-toggle="buttons">
                                            <label class="btn btn-sm btn-default" >
                                                <input type="radio" name="options" class="btn-filter" data-filter="all" autocomplete="off" >
                                                {{ trans('products.filter_all') }}
                                            </label>

                                            <label class="btn btn-sm btn-default" title="Active Products">

                                                <input type="radio" name="options"  class="btn-filter" data-filter="active" autocomplete="off">

                                                <i class="fa fa-eye text-success"></i>

                                                {{ trans('products.filter_active') }}

                                            </label>

                                            <label class="btn btn-sm btn-default" title="Rejected Products">

                                                <input type="radio" name="options" class="btn-filter" data-filter="rejected" autocomplete="off">

                                                <i class="fa fa-eye-slash text-danger"></i>

                                                {{ trans('products.filter_not_active') }}

                                            </label>

                                            <label class="btn btn-sm btn-default" title="Today products">

                                                <input type="radio" name="options" class="btn-filter" data-filter="today" autocomplete="off">

                                                <i class="fa fa-bell text-info "></i>

                                                {{ trans('products.filter_today') }}

                                            </label>

                                        </div>

                                    </div>

                                    <div class="col-md-3 col-xs-3">

                                        <div class="dropdown">

                                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">

                                                {{ trans('products.set_as') }}<i class="fa fa-cogs text-danger"></i>

                                                <span class="caret"></span>

                                            </button>

                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">

                                                <li><a href="#" class="btn-action"  data-action="active"><span><i class="fa fa-eye text-primary"></i></span> &nbsp;{{ trans('products.active') }}  </a></li>

                                                <li><a href="#" class="btn-action"  data-action="rejected"><span><i class="fa fa-eye-slash text-danger"></i></span> &nbsp;{{ trans('products.not_active') }}  </a></li>

                                            </ul>

                                        </div>
                                    </div>
                                </div>

                                <div class=" ser-a-del col-md-4 col-sm-4">

                                    <div class="col-md-8 bcol-sm-8 inner-col">

                                        <div class="input-group">

                                            <input type="text" class="form-control input-sm"  id="input-search" placeholder="{{ trans('products.search_placeholder') }}">

                                            <span class="input-group-btn">

                                                <button class="btn btn-sm btn-success btn-search" data-search="product" type="button">

                                                    <i class="fa fa-search"></i>

                                                </button>

                                            </span>

                                        </div>

                                    </div>

                                    <div class="addNew col-md-4 bcol-sm-4">

                                        <button type="button" class="btn btn-danger btn-sm btn-action"  data-action="deleted">

                                            <i class="fa fa-trash"></i>

                                            {{ trans('products.btn_delete') }}

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="row" id="ajax-table">

                            <div class="table-responsive">

                                <table id="example" class="table table-bordered table-striped table-responsive text-center">
                                    <thead>
                                        <tr>
                                            <th id="ID">
                                                <input id="chk-all" type="checkbox">
                                            </th>
                                            <th>{{ trans('products.name_col') }}</th>
                                            <th>{{ trans('products.status_col') }}</th>
                                            <th>{{ trans('products.category_col') }}</th>
                                            <!--<th>{{ trans('products.stock_status_col') }}</th>-->
                                            <th>{{ trans('products.updated_at_col') }}</th>
                                            <th class="text-center">{{ trans('products.operations_col') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)

                                        <tr class="{{ $product->active ? 'success' : 'warning' }}">
                                            @php
                                            $ar = $product->translated('ar');
                                            $en = $product->translated('en');
                                            @endphp

                                            <td class="ID">

                                                <input name="ids[]" class="chk-box" value="{{ $product->id}}" type="checkbox">

                                            </td>

                                            <td>{{ "$en->name | $ar->name" }}</td>

                                            <td>{{ $product->active ?  trans('products.active') : trans('products.not_active')}}</td>

                                            <td>{{ $product->category->translated('en')->name . " | " .$product->category->translated('ar')->name}}</td>

<!--                                                <td>
                                                    @if ($product->outOfStock())
                                                        <label class="label label-danger">{{ trans('products.label_out_of_stock') }}</label>
                                                    @elseif ($product->hasLowStock())
                                                        <label class="label label-warning">{{ trans('products.label_low_of_stock') }}</label>
                                                    @else
                                                        <label class="label label-success">{{ trans('products.label_in_stock') }}</label>
                                                    @endif
                                                </td>-->

                                            <td>{{ $product->updated_at->diffForHumans() }}</td>

                                            <td class="text-center">
                                                <a href="{{ route('admin.products.edit' , ['id' => $product->id ]) }}" class="edit-btn btn green">
                                                    <li class="fa fa-edit">
                                                        {{ trans('products.btn_edit_view') }}
                                                    </li>
                                                </a>

                                                <a data-url="{{ route('admin.products.delete' , ['id' => $product->id ]) }}" class="btn btn-danger btndelet btn">
                                                    <li class="fa fa-trash">
                                                        {{trans('products.btn_delete')}}
                                                    </li>
                                                </a>

                                            </td>

                                        </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                            {{ $products->links() }}

                        </div>

                    </div>

                    {{ csrf_field() }}

                </form>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
</div>
@endsection