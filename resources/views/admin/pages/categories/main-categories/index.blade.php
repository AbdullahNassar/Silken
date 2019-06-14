@extends('admin.layouts.master')
@section('title')
   Main Categories data
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
                    <a href="#">Main Categories Data</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-list-ol"></i>Main Categories data</div>
                        <div class="tools">
                            <a href="javascript:;" class="reload"> </a>
                            <a href="javascript:;" class="collapse"> </a>
                        </div>
                        <br />
                    </div>

                    <div class="portlet-body form">
                        <form action="{{route('admin.categories.add',['type'=>'main'])}}" onsubmit="return false;" method="post" >
                            {!! csrf_field() !!}
                            <div class="form-body row">
                                <div class="form-group col-sm-6 col-md-6">
                                    <label class="col-md-3 control-label">Category Name (In English)</label>
                                    <div class="col-md-9 col-sm-6">
                                        <input type="text" class="form-control" name="en_name" placeholder="Enter title">
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 col-md-6">
                                    <label class="col-md-3 control-label">Category Name (In Arabic)</label>
                                    <div class="col-md-9 col-sm-6">
                                        <input type="text" class="form-control" name="ar_name" placeholder="Enter Content">
                                    </div>
                                </div>

                                <div class="form-group col-md-6 col-sm-6 ">
                                    <label class="col-md-3 control-label">Category Status</label>
                                    <div class="col-md-9 col-sm-6">
                                        <select class="form-control" name="active">
                                            <option value="">{{trans('categories.choose_status')}}</option>
                                            <option value="1">Active | فعال</option>
                                            <option value="0">Not Active | غير فعال</option>
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
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="font-dark"></i>
                            <span class="caption-subject bold uppercase">All data</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered table-striped table-responsive text-center">
                                <thead>
                                <tr >
                                    <th>Category Name</th>
                                    <th>Category Status</th>
                                    <th>Operations</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    @php
                                        $en = $category->translated('en');
                                        $ar = $category->translated('ar');
                                    @endphp
                                    <tr {{$category->active ? 'info' : 'warning'}}>
                                        <td>{{"$en->name | $ar->name"}}</td>
                                        <td>
                                            {{$category->active ? 'Active | فعال' : 'Not Active | غير فعال'}}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.categories.info' , ['id' => $category->id ]) }}" class="edit-btn btn green">
                                                <li class="fa fa-edit">
                                                    Edit
                                                </li>
                                            </a>
                                            <a data-url="{{ route('admin.categories.delete' , ['id' => $category->id ]) }}" class="btn btn-danger btndelet btn">
                                                <li class="fa fa-trash">
                                                    Delete
                                                </li>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                {{$categories->links()}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
@endsection