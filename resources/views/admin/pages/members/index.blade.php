@extends('admin.layouts.master')
@section('title')
Members
@endsection
@section('content')
<div class="page-content">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{url('/')}}">Home</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>Members</span>
            </li>
        </ul>
    </div>
    <div class="row">

        <div class="col-md-12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-users"></i>All Members</div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"> </a>
                        <a href="javascript:;" class="remove"> </a>
                    </div>
                </div>

                <div class="portlet-body form">
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>

                                    <th> Fill Name</th>
                                    <th>Email</th>
                                    <!--<th>Phone</th>-->

                                    <!--<th>Address</th>-->
                                    <th>Date</th>
                                    <th class="text-center">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($members as $member)
                                <tr>
                                    <td>{{$member->name}}</td>
                                    <td>{{$member->email}}</td>
                                    <!--<td>{{$member->phone}}</td>-->
                                    <!--<td>{{$member->address}}</td>-->
                                    <td>{{$member->created_at->format('Y/m/d')}}</td>
                                    <td>
                                        {{--active == 0  => not active  --}}
                                        {{--active == 1  => active  --}}
                                        @if($member->active == 0)
                                        <button  data-url="{{route('admin.member.active')}}" data-id="{{$member->id}}" data-token="{{csrf_token()}}" class="btn btn-primary approveBTN">
                                            <li class="fa fa-pencil"> Activate</li>
                                        </button>
                                        @else
                                        <button  data-url="{{route('admin.member.disActive')}}" data-id="{{$member->id}}" data-token="{{csrf_token()}}" class="btn btn green approveBTN">
                                            <li class="fa fa-pencil"> DisActivate</li>
                                        </button>

                                        @endif
                                        @if($member->active ==  -1)
                                        <button  data-url="{{route('admin.member.active')}}" data-token="{{csrf_token()}}" data-id="{{$member->id}}" class="btn btn-warning approveBTN">
                                            <li class="fa fa-pencil"> Un Block</li>
                                        </button>
                                        @else
                                        <button  data-url="{{route('admin.member.block')}}" data-token="{{csrf_token()}}" data-id="{{$member->id}}" class="btn btn-warning approveBTN">
                                            <li class="fa fa-pencil"> Block</li>
                                        </button>

                                        @endif


<!--                                        <button type="button" class="btn btn-danger btndelet " data-id="{{ $member->id }}"
                                                data-url="{{ route('admin.member.delete' , ['id' => $member->id ]) }}" >
                                            <i class="fa fa-trash"></i>
                                            Delete
                                        </button>-->
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
