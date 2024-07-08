@extends('layouts.master')
@section('css')
<!--Internal  Font Awesome -->
<link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<!--Internal  treeview -->
<link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
@section('title')
اضافة مدرب
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المدربيين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة مدرب</span>
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
                <a class="btn btn-primary btn-sm" href="{{ route('trainer.index') }}">رجوع</a>
            </div>
        </div><br>
        <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"  enctype="multipart/form-data"
            action="{{route('trainer.store')}}" method="post">
            {{csrf_field()}}

            <div class="">

            <div class="row mg-b-20">
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>اسم المدرب :</label>
                        <input class="form-control form-control-sm mg-b-20" name="name" value="" required type="text">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>المستوى التعليمي :</label>
                        <input class="form-control form-control-sm mg-b-20" name="educational_level" value="" required type="text">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label> الجنس :</label>
                        <select id="gender" name="gender" class="form-control">
                            <option value="" disabled selected></option>
                                <option value="female">female</option>
                                <option value="male">male</option>
                        </select>
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label> instagram :</label>
                        <input class="form-control form-control-sm mg-b-20" name="instagram" value="" required type="text">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label> الإيميل :</label>
                        <input class="form-control form-control-sm mg-b-20" name="email" value="" required type="email">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label> رقم الجوال:</label>
                        <input class="form-control form-control-sm mg-b-20" name="phone" value="" required type="text">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>الشهادة :</label>
                        <input class="form-control form-control-sm mg-b-20" name="certificate" type="file">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label> الصورة الشخصية :</label>
                        <input class="form-control form-control-sm mg-b-20" name="personal_photo" type="file">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label> صورة الهوية  :</label>
                        <input class="form-control form-control-sm mg-b-20" name="identity_photo" type="file">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>تاريخ الميلاد :</label>
                        <input class="form-control form-control-sm mg-b-20" name="birth_date" value="" required type="date">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>لمحة عن المدرب :</label>
                        <input class="form-control form-control-sm mg-b-20" name="about" value="" required type="text">
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