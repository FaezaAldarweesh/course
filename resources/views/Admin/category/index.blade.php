@extends('layouts.master')
@section('css')
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@section('title')
    التصنيفات   
@stop


@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">التصنيفات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> / إدارةالتصنيفات</span>
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

<!-- Display Restore,ForceDelet  -->
@if (session('success'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                                @can('اضافة تصنيف')
                                <a class="btn ripple btn-warning" href="{{ route('categories.create') }}">اضافة تصنيف</a>
                                @endcan
                        </div>
                    </div>
                    <br>
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mg-b-0 text-md-nowrap table-hover ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>الصورة</th>
                                <th>الوصف</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td><img src="{{ asset('images/' . $category->photo) }}" alt="{{ $category->name }}" width="100" height="50"></td>
                                    <td>{{ $category->description }}</td>
                                    <td>

                                        <a class="btn btn-primary btn-sm"
                                        @can('تعديل تصنيف')
                                            href="{{ route('categories.edit', $category->id) }}">تعديل</a>
                                        @endcan
                             
                                        @can('حذف تصنيف')
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" 
                                        data-target="#deleteCategoryModal" data-category_id="{{ $category->id }}" 
                                        data-category_name="{{ $category->name }}" title="حذف">
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
    <!--/div-->
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" 
     aria-labelledby="deleteCategoryModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="deleteCategoryForm" method="POST">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <p>هل انت متأكد من عملية الحذف؟</p><br>
                    <input type="hidden" name="Category_id" id="Category_id" value="">
                    <input class="form-control" name="Category_name" id="Category_name" type="text" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">تاكيد</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Notify js -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

<script>
    $(document).ready(function(){
        $('#deleteCategoryModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
            var Category_id = button.data('category_id'); 
            var Category_name = button.data('category_name'); 

            var modal = $(this);
            modal.find('.modal-body #Category_id').val(Category_id);
            modal.find('.modal-body #Category_name').val(Category_name);

            // Update the form action
            var formAction = "{{ route('categories.destroy', ':id') }}";
            formAction = formAction.replace(':id', Category_id);
            modal.find('#deleteCategoryForm').attr('action', formAction);
        });
    });
</script>


@endsection