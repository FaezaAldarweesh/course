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
            <span class="text-muted mt-1 tx-13 mr-2 mb-0"> / إدارة الطلاب</span>
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
                            @can('اضافة طالب')
                            <a class="btn ripple btn-warning" href="{{ route('student.create') }}">اضافة طالب</a>
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
                                <th>رقم الجوال</th>
                                <th>الإيميل</th>
                                <th>الصورة الشخصية</th>
                                <th>تاريخ الميلاد</th>
                                <th>المستوى التعليمي</th>
                                <th>الجنس</th>
                                <th>المسكن</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td><img src="{{ asset('images/student/' . $student->personal_photo) }}" alt="{{ $student->name }}" width="100" height="50"></td>
                                    <td>{{ $student->birth_date }}</td>
                                    <td>{{ $student->educational_level }}</td>
                                    @if($student->gender == 'female' )
                                    <td>أنثى</td>
                                    @else
                                    <td>ذكر</td>
                                    @endif
                                    <td>{{ $student->location }}</td>
                                    <td>
                                        @can('تعديل طالب')
                                        <a class="btn btn-primary btn-sm" href="{{ route('student.edit', $student->id) }}">تعديل</a>
                                        @endcan

                                        @can('حذف طالب')
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteStudentModal" data-student_id="{{ $student->id }}"
                                            data-student_name="{{ $student->name }}" title="حذف">
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

<div class="modal fade" id="deleteStudentModal" tabindex="-1" role="dialog"
     aria-labelledby="deleteStudentModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="deleteStudentForm" method="POST">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <p>هل انت متأكد من عملية الحذف؟</p><br>
                    <input type="hidden" name="student_id" id="student_id" value="">
                    <input class="form-control" name="student_name" id="student_name" type="text" readonly>
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
        $('#deleteStudentModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var student_id = button.data('student_id');
            var student_name = button.data('student_name');

            var modal = $(this);
            modal.find('.modal-body #student_id').val(student_id);
            modal.find('.modal-body #student_name').val(student_name);

            // Update the form action
            var formAction = "{{ route('student.destroy', ':id') }}";
            formAction = formAction.replace(':id', student_id);
            modal.find('#deleteStudentForm').attr('action', formAction);
        });
    });
</script>
@endsection
