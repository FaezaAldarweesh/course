@extends('layouts.master')
@section('css')
<!--Internal Font Awesome -->
<link href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
<!--Internal treeview -->
<link href="{{ URL::asset('assets/plugins/treeview/treeview-rtl.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('title')
تعديل تسجل طالب 
@stop
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الطلاب</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل تسجيل طالب</span>
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
                <a class="btn btn-primary btn-sm" href="{{ route('student_course.index') }}">رجوع</a>
            </div>
        </div><br>
        <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
            action="{{ route('student_course.update', $StudentCourses->id) }}" method="post">
            @csrf
            @method('PUT')

            <div class="">
                <div class="row mg-b-20">
                <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>اسم الطالب :</label>
                        <select class="form-control form-control-sm mg-b-20" name="student_id" required>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}" {{ $StudentCourses->student_id == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>اسم الكورس :</label>
                        <select class="form-control form-control-sm mg-b-20" name="course_id" required>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" {{ $StudentCourses->course_id == $course->id ? 'selected' : '' }}>
                                    {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>الحالة :</label>
                        <select id="status" name="status" class="form-control">
                            <option value="paid" {{ $StudentCourses->status == 'paid' ? 'selected' : '' }}>paid</option>
                            <option value="unpaid" {{ $StudentCourses->status == 'unpaid' ? 'selected' : '' }}>unpaid</option>
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
