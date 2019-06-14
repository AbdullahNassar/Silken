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
                        <form action="{{ route('admin.categories.edit' , ['id' => $category->id , 'type' => 'sub'])}}" onsubmit="return false;" method="post" >
                            {!! csrf_field() !!}
                            @php
                                $en = $category->translated('en');
                                $ar = $category->translated('ar');
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
                                            <option value="1" {{ $category->active? 'selected' : '' }}>Active | فعال</option>
                                            <option value="0" {{ !$category->active? 'selected' : '' }}>Not Active | غير فعال</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 ">
                                    <label class="col-md-3 control-label">Category Status</label>
                                    <div class="col-md-9 col-sm-6">
                                        <select class="form-control" name="parent_id">
                                            @foreach (App\Category::all() as $cat)
                                                @if($cat->isMain())
                                                    @php
                                                        $en = $cat->translated('en');
                                                        $ar = $cat->translated('ar');
                                                    @endphp
                                                    <option value="{{ $cat->id }}" @if($category->parent_id == $cat->id) selected @endif>{{ "$en->name | $ar->name" }}</option>
                                                @endif
                                            @endforeach
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