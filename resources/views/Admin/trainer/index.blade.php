@extends('layouts.master')
@section('css')
    <!--Internal Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@section('title')
    المدربيين
@stop
@endsection

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المدربيين</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0"> / إدارة المدربيين</span>
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
                            <a class="btn ripple btn-warning" href="{{ route('trainer.create') }}">اضافة مدرب</a>
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
                                <th>اسم المدرب</th>
                                <th>المستوى التعليمي</th>
                                <th>الجنس</th>
                                <th>انستاغرام</th>
                                <th>الشهادة</th>
                                <th>الصورة الشخصية</th>
                                <th>صورة الهوية</th>
                                <th>الإيميل</th>
                                <th>رقم الجوال</th>
                                <th>تاريخ الميلاد</th>
                                <th>لمحة عن المدرب</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainers as $trainer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $trainer->name }}</td>
                                    <td>{{ $trainer->educational_level }}</td>
                                     @if($trainer->gender == 'female' )
                                    <td>أنثى</td>
                                    @else
                                    <td>ذكر</td>
                                    @endif
                                    <td>{{ $trainer->instagram }}</td>
                                    <td><img src="{{ asset('images/trainer/' . $trainer->certificate) }}" alt="{{ $trainer->name }}" width="100" height="50"></td>
                                    <td><img src="{{ asset('images/trainer/' . $trainer->personal_photo) }}" alt="{{ $trainer->name }}" width="100" height="50"></td>
                                    <td><img src="{{ asset('images/trainer/' . $trainer->identity_photo) }}" alt="{{ $trainer->name }}" width="100" height="50"></td>
                                    <td>{{ $trainer->email }}</td>
                                    <td>{{ $trainer->phone }}</td>
                                    <td>{{ $trainer->birth_date }}</td>
                                    <td>{{ $trainer->about }}</td>

                                    <td>
                                        @can('تعديل مدرب')
                                        <a class="btn btn-primary btn-sm" href="{{ route('trainer.edit', $trainer->id) }}">تعديل</a>
                                        @endcan

                                        @can('حذف مدرب')
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteTrainerModal" data-trainer_id="{{ $trainer->id }}"
                                            data-trainer_name="{{ $trainer->name }}" title="حذف">
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

<div class="modal fade" id="deleteTrainerModal" tabindex="-1" role="dialog"
     aria-labelledby="deleteTrainerModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="deleteTrainerForm" method="POST">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <p>هل انت متأكد من عملية الحذف؟</p><br>
                    <input type="hidden" name="trainer_id" id="trainer_id" value="">
                    <input class="form-control" name="trainer_name" id="trainer_name" type="text" readonly>
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
        $('#deleteTrainerModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var trainer_id = button.data('trainer_id');
            var trainer_name = button.data('trainer_name');

            var modal = $(this);
            modal.find('.modal-body #trainer_id').val(trainer_id);
            modal.find('.modal-body #trainer_name').val(trainer_name);

            // Update the form action
            var formAction = "{{ route('trainer.destroy', ':id') }}";
            formAction = formAction.replace(':id', trainer_id);
            modal.find('#deleteTrainerForm').attr('action', formAction);
        });
    });
</script>
@endsection
