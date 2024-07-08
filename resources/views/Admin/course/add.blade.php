@extends('layouts.master')
@section('css')
<!--Internal  Font Awesome -->
<link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<!--Internal  treeview -->
<link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
@section('title')
اضافة كورس
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الكورسات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة كورس</span>
        </div>
    </div>
</div>
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
                <a class="btn btn-primary btn-sm" href="{{ route('course.index') }}">رجوع</a>
            </div>
        </div><br>
        <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"  enctype="multipart/form-data"
            action="{{route('course.store')}}" method="post">
            {{csrf_field()}}

            <div class="">

            <div class="row mg-b-20">
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>اسم التصنيف :</label>
                        <select class="form-control form-control-sm mg-b-20" name="category_id" required>
                        <option value="" disabled selected>Select a category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>اسم المدرب :</label>
                        <select class="form-control form-control-sm mg-b-20" name="trainer_id" required>
                            <option value="" disabled selected>Select a trainer</option>
                            @foreach ($trainers as $trainer)
                                <option value="{{ $trainer->id }}">{{ $trainer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>اسم الكورس :</label>
                        <input class="form-control form-control-sm mg-b-20" name="name" value="" required type="text">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>الوصف :</label>
                        <input class="form-control form-control-sm mg-b-20" name="description" value="" required type="text">
                    </div>


                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>العمر :</label>
                        <input class="form-control form-control-sm mg-b-20" name="age" value="" required type="number">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>عدد الطلاب :</label>
                        <input class="form-control form-control-sm mg-b-20" name="number_of_students" value="" required type="number">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label> السعر :</label>
                        <input class="form-control form-control-sm mg-b-20" name="price" value="" required type="number">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label> عدد الجلسات :</label>
                        <input class="form-control form-control-sm mg-b-20" name="number_of_sessions" value="" required type="number">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>تاريخ البداية :</label>
                        <input class="form-control form-control-sm mg-b-20" name="start_date" value="" required type="date">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>تاريخ النهاية :</label>
                        <input class="form-control form-control-sm mg-b-20" name="end_date" value="" required type="date">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label> الوقت :</label>
                        <input class="form-control form-control-sm mg-b-20" name="time" value="" required type="time">
                    </div>
                
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>الصورة :</label>
                        <input class="form-control form-control-sm mg-b-20" name="photo" type="file">
                    </div>

                </div>                   
                   
                </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button class="btn btn-main-primary pd-x-20" type="submit">تاكيد</button>
            </div>
        </form>
    </div>
</div>


<!-- row -->

<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->


@endsection
@section('js')
<!-- Internal Treeview js -->
<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
@endsection