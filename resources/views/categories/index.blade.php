@extends('admin_layouts.inc')
@section('title','الأقسام')
@section('breadcrumb','الأقسام')
@section('styles')
  <link href="{{ asset('/admin_ui/assets/layouts/layout4/css/image.css')}}" rel="stylesheet" type="text/css" />
  {{--<style>--}}
    {{--.switch {--}}
      {{--position: relative;--}}
      {{--display: inline-block;--}}
      {{--width: 68px;--}}
      {{--height: 57px;--}}
    {{--}--}}

    {{--.switch input {--}}
      {{--opacity: 0;--}}
      {{--width: 0;--}}
      {{--height: 0;--}}
    {{--}--}}

    {{--.slider {--}}
      {{--position: absolute;--}}
      {{--cursor: pointer;--}}
      {{--top: 0;--}}
      {{--left: 0;--}}
      {{--right: 0;--}}
      {{--bottom: 0;--}}
      {{--background-color: #ccc;--}}
      {{---webkit-transition: .4s;--}}
      {{--transition: .4s;--}}
    {{--}--}}

    {{--.slider:before {--}}
      {{--position: absolute;--}}
      {{--content: "";--}}
      {{--height: 26px;--}}
      {{--width: 26px;--}}
      {{--left: 4px;--}}
      {{--bottom: 4px;--}}
      {{--background-color: white;--}}
      {{---webkit-transition: .4s;--}}
      {{--transition: .4s;--}}
    {{--}--}}

    {{--input:checked + .slider {--}}
      {{--background-color: #2196F3;--}}
    {{--}--}}

    {{--input:focus + .slider {--}}
      {{--box-shadow: 0 0 1px #2196F3;--}}
    {{--}--}}

    {{--input:checked + .slider:before {--}}
      {{---webkit-transform: translateX(26px);--}}
      {{---ms-transform: translateX(26px);--}}
      {{--transform: translateX(26px);--}}
    {{--}--}}

    {{--/* Rounded sliders */--}}
    {{--.slider.round {--}}
      {{--border-radius: 34px !important;--}}
    {{--}--}}

    {{--.slider.round:before {--}}
      {{--border-radius: 50%;--}}
    {{--}--}}
  {{--</style>--}}
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
          <span class="caption-subject bold uppercase">بيانات الأقسام</span>
        </div>
        <div class="tools"> </div>
      </div>
      <div class="portlet-body">
        <div class="table-toolbar">
          <div class="row">
            <div class="col-md-6">
              <div class="btn-group">
                <button  data-toggle="modal" data-target="#addModal" id="sample_editable_1_new" class="btn btn-primary">
                  أضافة قسم
                  <i class="fa fa-plus"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
              <table class="table table-striped table-bordered table-hover table-header-fixed" id="categories">
                <thead>
                  <th class="col-md-1">أسم القسم</th>
                  <th class="col-md-1">الصورة</th>
                  <th class="col-md-1">الترتيب</th>
                  <th class="col-md-1">نشط</th>
                  <th class="col-md-1">خيارات</th>
                </thead>
                <tbody>
                  @foreach ($tableData->getData()->data as $row)
                  <tr>
                    <td>{{  $row->name }}</td>
                    <td>{!! $row->image !!}</td>
                    <td>{{  $row->sort }}</td>
                    <td>{{  $row->is_active }}</td>
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

      @include('admin_layouts.Add_imgModal')
      @include('admin_layouts.Edit_imgModal')

      @endsection

      @section('scripts')
        <script src="{{ asset('/admin_ui/assets/layouts/layout4/scripts/multipart_insert.js')}}" type="text/javascript"></script>
        <script src="{{ asset('/admin_ui/assets/layouts/layout4/scripts/upload.js')}}" type="text/javascript"></script>
        <script src="{{ asset('/admin_ui/assets/layouts/layout4/scripts/app.js') }}"></script>
      <script type="text/javascript">
       $(document).ready(function() {
        oTable = $('#categories').DataTable({
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
          {data: 'name', name: 'name'},
          {data: 'image', name: 'image'},
          {data: 'sort', name: 'sort'},
          {data: 'is_active', name: 'is_active'},
          {data: 'actions', name: 'actions', orderable: false, searchable: false}
          ]
        })
      });
    </script>
      <script src="{{ asset('/admin-ui/js/for_pages/table.js') }}"></script>
    @endsection
