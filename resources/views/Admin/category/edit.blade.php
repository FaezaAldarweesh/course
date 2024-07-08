@extends('layouts.master')
@section('css')
<!--Internal  Font Awesome -->
<link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<!--Internal  treeview -->
<link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
 <!-- Display session errors -->
 @if (session('error'))
 <div class="alert alert-danger alert-dismissible fade show" role="alert">
     <strong>{{ session('error') }}</strong>
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
     </button>
 </div>
@endif

<!-- Display Restore,ForceDelet  -->
@if (session('success'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
   <strong>{{ session('success') }}</strong>
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
   </button>
</div>
@endif   
@section('title')
تعديل التصنيف 
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">التصنيفات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل التصنيف</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')

@if (count($errors) > 0)
<div class="alert alert-danger">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>خطا</strong>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-primary btn-sm" href="{{ route('categories.index') }}">رجوع</a>
            </div>
        </div><br>
        <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2" enctype="multipart/form-data"
            action="{{route('categories.update',$Category->id)}}" method="post">
            @csrf
            @method('PUT')

            <div class="">

                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>اسم التصنيف :</label>
                        <input class="form-control form-control-sm mg-b-20"
                            data-parsley-class-handler="#lnWrapper" value="{{$Category->name}}" name="name" required="" type="text">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>الصورة :</label>
                        <input class="form-control form-control-sm mg-b-20" name="photo" type="file">
                        @if($Category->photo)
                            <div>
                                <label for="exampleInputEmail1" class="current-photo-label"> الصورة الحالية: </label>
                                <img src="{{ asset('images/' . $Category->photo) }}" alt="{{ $Category->photo }}" width="100" height="50">
                                <input type="hidden" class="form-control" name="old_photo" value="{{ $Category->photo }}">
                            </div>
                        @endif
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>الوصف :</label>
                        <input class="form-control form-control-sm mg-b-20"
                            data-parsley-class-handler="#lnWrapper" value="{{$Category->description}}" name="description" required="" type="text">
                    </div>
                </div>                   
                </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button class="btn btn-main-primary pd-x-20" type="submit">تحديث</button>
            </div>
        </form>
    </div>
</div>

<!-- row closed -->
</div>
<!-- Container closed -->
</div>

@endsection
@section('js')
<!-- Internal Treeview js -->
<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
@endsection