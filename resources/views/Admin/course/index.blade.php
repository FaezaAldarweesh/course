@extends('layouts.master')
@section('css')
    <!--Internal Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@section('title')
    الكورسات
@stop
@endsection

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الكورسات</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0"> / إدارة الكورسات</span>
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
                            @can('اضافة كورس')
                            <a class="btn ripple btn-warning" href="{{ route('course.create') }}">اضافة كورس</a>
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
                                <th>اسم التصنيف</th>
                                <th>اسم المدرب</th>
                                <th>اسم الكورس</th>
                                <th>الوصف</th>
                                <th>العمر</th>
                                <th>عدد الطلاب</th>
                                <th>عدد الطلاب المسجلين</th>
                                <th>السعر</th>
                                <th>عدد الجلسات</th>
                                <th>تاريخ البداية</th>
                                <th>تاريخ النهاية</th>
                                <th>الوقت</th>
                                <th>الصورة</th>
                                <th>الحالة</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $course->category->name }}</td>
                                    <td>{{ $course->trainer->name }}</td>
                                    <td>{{ $course->name }}</td>
                                    <td>{{ $course->description }}</td>
                                    <td>{{ $course->age }}</td>
                                    <td>{{ $course->number_of_students }}</td>
                                    <td>{{ $course->number_of_students_paid }}</td>
                                    <td>{{ $course->price }}</td>
                                    <td>{{ $course->number_of_sessions }}</td>
                                    <td>{{ $course->start_date }}</td>
                                    <td>{{ $course->end_date }}</td>
                                    <td>{{ $course->time }}</td>
                                    <td><img src="{{ asset('images/' . $course->photo) }}" alt="{{ $course->name }}" width="100" height="50"></td>
                                    @if($course->status == 'available')
                                    <td>متاح</td>
                                    @elseif($course->status == 'unavailable')
                                    <td>غير متاح</td>
                                    @else
                                    <td>مكتمل العدد</td>
                                    @endif
                                    <td>
                                        @can('تعديل كورس')
                                        <a class="btn btn-primary btn-sm" href="{{ route('course.edit', $course->id) }}">تعديل</a>
                                        @endcan

                                        @can('حذف كورس')
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteCourseModal" data-course_id="{{ $course->id }}"
                                            data-course_name="{{ $course->name }}" title="حذف">
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

<div class="modal fade" id="deleteCourseModal" tabindex="-1" role="dialog"
     aria-labelledby="deleteCourseModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="deleteCourseForm" method="POST">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <p>هل انت متأكد من عملية الحذف؟</p><br>
                    <input type="hidden" name="course_id" id="course_id" value="">
                    <input class="form-control" name="course_name" id="course_name" type="text" readonly>
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
        $('#deleteCourseModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var course_id = button.data('course_id');
            var course_name = button.data('course_name');

            var modal = $(this);
            modal.find('.modal-body #course_id').val(course_id);
            modal.find('.modal-body #course_name').val(course_name);

            // Update the form action
            var formAction = "{{ route('course.destroy', ':id') }}";
            formAction = formAction.replace(':id', course_id);
            modal.find('#deleteCourseForm').attr('action', formAction);
        });
    });
</script>
@endsection
