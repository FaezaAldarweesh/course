@extends('layouts.master')
@section('css')
    <!--Internal Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@section('title')
    الطلاب
@stop
@endsection

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الطلاب</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0"> / إدارة تسجيل الطلاب</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')

<!-- Display session errors -->
@if (session('error'))
 <div class="alert alert-danger alert-dismissible fade show" role="alert">
     <strong>{{ session('error') }}</strong>
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
     </button>
 </div>
@endif

<!-- Display success message -->
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
   <strong>{{ session('success') }}</strong>
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
   </button>
</div>
@endif

<!-- row -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">
                            @can('تسجيل طالب')
                            <a class="btn ripple btn-warning" href="{{ route('student_course.create') }}"> تسجيل طالب</a>
                            @endcan
                        </div>
                    </div>
                    <br>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mg-b-0 text-md-nowrap table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم الطالب</th>
                                <th>اسم الكورس</th>
                                <th>الحالة</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($StudentCourses as $StudentCourse)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $StudentCourse->Student->name }}</td>
                                    <td>{{ $StudentCourse->Course->name }}</td>
                                    <td>{{ $StudentCourse->status }}</td>
                                    <td>
                                        @can('تعديل تسجيل الطالب')
                                        <a class="btn btn-primary btn-sm" href="{{ route('student_course.edit', $StudentCourse->id) }}">تعديل</a>
                                        @endcan

                                        @can('حذف تسجيل الطالب')
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteStudentCoursesModal" data-studentcourse_id="{{ $StudentCourse->id }}" title="حذف">
                                            <i class="las la-trash"></i>
                                        </button>
                                        @endcan
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
<!-- row closed -->
</div>
<!-- Container closed -->
</div>

<div class="modal fade" id="deleteStudentCoursesModal" tabindex="-1" role="dialog"
     aria-labelledby="deleteStudentCoursesModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="deleteStudentCoursesForm" method="POST">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <p>هل انت متأكد من عملية الحذف؟</p><br>
                    <input type="hidden" name="StudentCourse_id" id="StudentCourse_id" value="StudentCourse_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">تاكيد</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
<!--Internal Notify js -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

<script>
$(document).ready(function(){
    $('#deleteStudentCoursesModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var StudentCourse_id = button.data('studentcourse_id'); 

        var modal = $(this);
        modal.find('.modal-body #StudentCourse_id').val(StudentCourse_id);

        // Update the form action
        var formAction = "{{ route('student_course.destroy', ':id') }}";
        formAction = formAction.replace(':id', StudentCourse_id);
        modal.find('#deleteStudentCoursesForm').attr('action', formAction);
    });
});

</script>
@endsection
