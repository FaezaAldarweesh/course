@extends('layouts.master')
@section('css')
<!--Internal Font Awesome -->
<link href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
<!--Internal treeview -->
<link href="{{ URL::asset('assets/plugins/treeview/treeview-rtl.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('title')
تعديل ألمدرب 
@stop
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المدربيين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل المدرب</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')

<!-- عرض الأخطاء -->
@if (count($errors) > 0)
<div class="alert alert-danger">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>خطأ</strong>
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
        <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
            action="{{ route('trainer.update', $trainer->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="">
                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>اسم المدرب :</label>
                        <input class="form-control form-control-sm mg-b-20" name="name" value="{{ $trainer->name }}" required type="text">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>المستوى التعليمي :</label>
                        <input class="form-control form-control-sm mg-b-20" name="educational_level" value="{{ $trainer->educational_level }}" required type="text">
                    </div>

                    
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label> الجنس :</label>
                        <select id="gender" name="gender" class="form-control" required>
                            <option value="" disabled {{ $trainer->gender ? '' : 'selected' }}>اختر الجنس</option>
                            <option value="male" {{ $trainer->gender == 'male' ? 'selected' : '' }}>ذكر</option>
                            <option value="female" {{ $trainer->gender == 'female' ? 'selected' : '' }}>أنثى</option>
                        </select>
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label> instagram :</label>
                        <input class="form-control form-control-sm mg-b-20" name="instagram" value="{{ $trainer->instagram }}" required type="text">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label> الإيميل :</label>
                        <input class="form-control form-control-sm mg-b-20" name="email" value="{{ $trainer->email }}" required type="email">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label> رقم الجوال:</label>
                        <input class="form-control form-control-sm mg-b-20" name="phone" value="{{ $trainer->phone }}" required type="text">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>الشهادة :</label>
                        <input class="form-control form-control-sm mg-b-20" name="certificate" type="file">
                        @if($trainer->certificate)
                            <div>
                                <label for="exampleInputEmail1" class="current-photo-label"> الصورة الحالية: </label>
                                <img src="{{ asset('images/trainer/' . $trainer->certificate) }}" alt="{{ $trainer->certificate }}" width="100" height="50">
                                <input type="hidden" class="form-control" name="old_photo" value="{{ $trainer->certificate }}">
                            </div>
                        @endif
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label> الصورة الشخصية :</label>
                        <input class="form-control form-control-sm mg-b-20" name="personal_photo" type="file">
                        @if($trainer->personal_photo)
                            <div>
                                <label for="exampleInputEmail1" class="current-photo-label"> الصورة الحالية: </label>
                                <img src="{{ asset('images/trainer/' . $trainer->personal_photo) }}" alt="{{ $trainer->personal_photo }}" width="100" height="50">
                                <input type="hidden" class="form-control" name="old_photo" value="{{ $trainer->personal_photo }}">
                            </div>
                        @endif
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label> صورة الهوية  :</label>
                        <input class="form-control form-control-sm mg-b-20" name="identity_photo" type="file">
                        @if($trainer->identity_photo)
                            <div>
                                <label for="exampleInputEmail1" class="current-photo-label"> الصورة الحالية: </label>
                                <img src="{{ asset('images/trainer/' . $trainer->identity_photo) }}" alt="{{ $trainer->identity_photo }}" width="100" height="50">
                                <input type="hidden" class="form-control" name="old_photo" value="{{ $trainer->identity_photo }}">
                            </div>
                        @endif
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>تاريخ الميلاد :</label>
                        <input class="form-control form-control-sm mg-b-20" name="birth_date" value="{{ $trainer->birth_date }}" required type="date">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>لمحة عن المدرب :</label>
                        <input class="form-control form-control-sm mg-b-20" name="about" value="{{ $trainer->about }}" required type="text">
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button class="btn btn-main-primary pd-x-20" type="submit">تحديث</button>
            </div>
        </form>
    </div>
</div>

@endsection
@section('js')
<!-- Internal Treeview js -->
<script src="{{ URL::asset('assets/plugins/treeview/treeview.js') }}"></script>
@endsection
