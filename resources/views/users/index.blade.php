@extends('admin_layouts.inc')
@section('title','الأعضاء')
@section('breadcrumb','الأعضاء')
@section('styles')
  <link href="{{ asset('/admin_ui/assets/layouts/layout4/css/image.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<!-- Main content -->
<div class="row">
  <div class="col-md-12">
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption font-dark">
          <i class="icon-settings font-dark"></i>
          <span class="caption-subject bold uppercase">بيانات الأعضاء</span>
        </div>
        <div class="tools"> </div>
      </div>
      <div class="portlet-body">
        <div class="table-toolbar">
          <div class="row">
            <div class="col-md-6">
              <div class="btn-group">
                <button  data-toggle="modal" data-target="#addModal" id="sample_editable_1_new" class="btn btn-primary">
                  أضافة عضو
                  <i class="fa fa-plus"></i>
                </button>
              </div>
              <div class="btn-group">
                <button  data-toggle="modal" data-target="#sendNotification" id="sample_editable_1_new" class="btn btn-primary">
                  ارسال أشعارات
                  <i class="fas fa-share-square"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
              <table class="table table-striped table-bordered table-hover" id="descriptions">
                <thead>
                <th class="col-md-1">أسم المستخدم</th>
                <th class="col-md-1">رقم التليفون</th>
                <th class="col-md-1">نشط</th>
                <th class="col-md-1">محظور</th>
                <th class="col-md-1">العناوين</th>
                <th class="col-md-1">الطلبات</th>
                <th class="col-md-1">خيارات</th>
                </thead>
                <tbody>
                  @foreach ($tableData->getData()->data as $row)
                  <tr>
                    <td>{{  $row->username }}</td>
                    <td>{{  $row->phone }}</td>
                    <td>{{  $row->is_active }}</td>
                    <td>{{  $row->is_blocked }}</td>
                    <td>{{  $row->addresses }}</td>
                    <td>{{  $row->orders }}</td>
                    <td>{!! $row->actions !!}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <!-- END EXAMPLE TABLE PORTLET-->
        </div>
      </div>

      @include('admin_layouts.Add_Modal')
      @include('admin_layouts.Edit_Modal')

<div class="modal fade" id="userOrdersModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addModalLabel"><i class="fa fa-plus-circle"></i> تفاصيل الطلب</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
              <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="userOrders">
                  <thead>
                  <th class="col-md-1">رقم الطلب</th>
                  <th class="col-md-1">الحاله</th>
                  </thead>
                  <tbody id="userOrderDetails"></tbody>
                </table>
              </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="sendNotification" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addModalLabel"><i class="fa fa-plus-circle"></i> أرسال أشعارات</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" class="sendForm" action="{{ url('/send-notifications') }}" data-toggle="validator">
          <div class="modal-body">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label for="exampleInputPassword1">الأشعار</label>
              <textarea rows="2" cols="30" id="notification" name="notification" class="form-control" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" id="sendButton" class="btn btn-primary">ارسال</button>
            <button type="button" class="btn btn-danger closeModal">غلق</button>

          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

      @section('scripts')
        <script src="{{ asset('/admin_ui/assets/layouts/layout4/scripts/insert.js')}}" type="text/javascript"></script>
      <script type="text/javascript">
        $("#sendNotification form").on('submit', function(e){
          if (!e.isDefaultPrevented())
          {
            var self = $(this);
            $('#sendButton').button('loading');
            $.ajax({
              url: self.closest('form').attr('action'),
              type: "POST",
              data: self.serialize(),
              beforeSend: function(){
                  if ($('#notification').val() == ""){
                    $('#sendButton').button('reset');
                    return false;
                  }
              },
              success: function(res){
                $('#sendButton').button('reset');
                $('.sendForm')[0].reset();
                $('#sendNotification').modal('hide');
                swal({
                  title: "تم أرسال الأشعار بنجاح",
                  type: "success",
                  closeOnConfirm: false,
                  confirmButtonText: "موافق !",
                  confirmButtonColor: "#ec6c62",
                  allowOutsideClick: true
                });
                oTable.draw();
              },
              error: function(error){
                $('#sendButton').button('reset');
                swal({
                  title: error['responseJSON']['msg'],
                  type: "error",
                  closeOnConfirm: false,
                  confirmButtonText: "موافق !",
                  confirmButtonColor: "#ff0000",
                  allowOutsideClick: true
                });
              }
            });
            e.preventDefault();
          }
        });


       $(document).ready(function() {
         $(document.body).validator().on('click', '.user-orders', function() {
           var self = $(this);
           self.button('loading');
           $.ajax({
             url: "user-orders/" + self.data('id') ,
             type: "GET",
             success: function(res){
               self.button('reset');
               $('#userOrderDetails').html(res);
               $('#userOrders').DataTable({ retrieve: true, order: [ [0, 'desc'] ], language: {
                   "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Arabic.json"
                 }});
               $('#userOrdersModal').modal('show');
             },
             error: function(){
               self.button('reset');
             }
           });
         });

        oTable = $('#descriptions').DataTable({
          "processing": true,
          "serverSide": true,
          "responsive": true,
          'paging'      : true,
          "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Arabic.json"
          },
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false,
          "ajax": {{ $tableData->getData()->recordsFiltered }},
          "columns": [
          {data: 'username', name: 'username'},
          {data: 'phone', name: 'phone'},
          {data: 'is_active', name: 'is_active'},
          {data: 'is_blocked', name: 'is_blocked'},
          {data: 'addresses', name: 'addresses'},
          {data: 'orders', name: 'orders'},
          {data: 'actions', name: 'actions', orderable: false, searchable: false}
          ]
        });
      });
    </script>
      <script src="{{ asset('/admin-ui/js/for_pages/table.js') }}"></script>
    @endsection
