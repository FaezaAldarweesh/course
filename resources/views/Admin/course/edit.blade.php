@extends('layouts.master')
@section('css')
<!--Internal Font Awesome -->
<link href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
<!--Internal treeview -->
<link href="{{ URL::asset('assets/plugins/treeview/treeview-rtl.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('title')
تعديل التصنيف 
@stop
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الكورسات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل الكورس</span>
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
                <a class="btn btn-primary btn-sm" href="{{ route('course.index') }}">رجوع</a>
            </div>
        </div><br>
        <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
            action="{{ route('course.update', $course->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="">
                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>اسم التصنيف :</label>
                        <select class="form-control form-control-sm mg-b-20" name="category_id" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $course->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>اسم المدرب :</label>
                        <select class="form-control form-control-sm mg-b-20" name="category_id" required>
                            @foreach ($trainers as $trainer)
                                <option value="{{ $trainer->id }}" {{ $trainer->id == $trainer->trainer_id ? 'selected' : '' }}>{{ $trainer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>اسم الكورس :</label>
                        <input class="form-control form-control-sm mg-b-20" name="name" value="{{ $course->name }}" required type="text">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>الوصف :</label>
                        <input class="form-control form-control-sm mg-b-20" name="description" value="{{ $course->description }}" required type="text">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>العمر :</label>
                        <input class="form-control form-control-sm mg-b-20" name="age" value="{{ $course->age }}" required type="number">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>عدد الطلاب :</label>
                        <input class="form-control form-control-sm mg-b-20" name="number_of_students" value="{{ $course->number_of_students }}" required type="number">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label> السعر :</label>
                        <input class="form-control form-control-sm mg-b-20" name="price" value="{{ $course->price }}" required type="number">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label> عدد الجلسات :</label>
                        <input class="form-control form-control-sm mg-b-20" name="number_of_sessions" value="{{ $course->number_of_sessions }}" required type="number">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>تاريخ البداية :</label>
                        <input class="form-control form-control-sm mg-b-20" name="start_date" value="{{ $course->start_date }}" required type="date">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>تاريخ النهاية :</label>
                        <input class="form-control form-control-sm mg-b-20" name="end_date" value="{{ $course->end_date }}" required type="date">
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label> الوقت :</label>
                        <input class="form-control form-control-sm mg-b-20" name="time" value="{{ $course->time }}" required type="time">
                    </div>
                
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>الصورة :</label>
                        <input class="form-control form-control-sm mg-b-20" name="photo" type="file">
                        @if($course->photo)
                            <div>
                                <label for="exampleInputEmail1" class="current-photo-label"> الصورة الحالية: </label>
                                <img src="{{ asset('images/' . $course->photo) }}" alt="{{ $course->name }}" width="100" height="50">
                                <input type="hidden" class="form-control" name="old_photo" value="{{ $course->photo }}">
                            </div>
                        @endif
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>الحالة :</label>
                        <select id="status" name="status" class="form-control">
                            <option value="paid" {{ $course->status == 'available' ? 'available' : '' }}>available</option>
                            <option value="unpaid" {{ $course->status == 'unavailable' ? 'unavailable' : '' }}>unavailable</option>
                            <option value="unpaid" {{ $course->status == 'completed' ? 'completed' : '' }}>completed</option>
                        </select>
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
