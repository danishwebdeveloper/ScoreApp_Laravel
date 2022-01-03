@extends('layouts.master')
@section('page_title', 'Talent Ranker - '.ling('admin_list'))


@section('content')

	<div class="m-heading-1 border-green m-bordered">
		<h5 style="display: inline-block">Talent Ranker - {{ ling('admin_list') }}!</h5>
		<a href="{{ url('admin_panel/add_admin') }}" class="btn btn-circle green-meadow pull-right"><i class="fa fa-plus"></i> {{ ling('add_new_admin') }}</a>
	</div>
	<div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-language font-green"></i>
                        <span class="caption-subject font-green bold uppercase"> {{ ling('admin_list') }}</span>
                    </div>
                </div>
                    <table class="table table-hover" id="sample_1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th> {{ ling('name') }} </th>
                                <th> {{ ling('country') }} </th>
                                <th> {{ ling('region') }} </th>
                                <th> {{ ling('email') }} </th>
                                <th> {{ ling('actions') }} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($admins) > 0)

                            @foreach($admins as $key => $admin)
                            @if($admin->seen == 0) 
                              @php $seen = '<span class="btn btn-xs yellow">New</span>' @endphp
                            @else
                              {{ $seen = '' }}
                            @endif
                            <tr>
                              <td>{{ $key+1 }}</td>
                              <td>{!! $seen !!} {{ $admin->name }}</td>
                              <td class="font-blue">{{ $admin->country_name }}</td>
                              <td class="font-blue">{{ $admin->region }}</td>
                              <td class="font-yellow">{{ $admin->email }}</td>
                              <td>
                                <a href="{{ url('admin_panel/edit_admin/'.$admin->user_id) }}" class="btn btn-xs green">
                                 {{ ling('edit') }} <i class="fa fa-edit"></i></a>
                                 <a href="javascript:void(0);" onclick="confirmDelete('{{ url('admin_panel/delete_admin/'.$admin->user_id) }}')" class="btn btn-xs red">
                                 {{ ling('delete') }} <i class="fa fa-trash"></i></a>
                              </td>
                            </tr>
                            @endforeach

                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>

@endsection

@section('style')
  @parent
  {{ Html::style('web/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}
  {{ Html::style('web/assets/global/plugins/datatables/datatables.min.css') }}
  {{ Html::style('web/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}
  {{ Html::style('web/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}
@stop

@section('javascript')
  @parent

  {{ Html::script('web/assets/pages/scripts/components-bootstrap-select.min.js') }}
  {{ Html::script('web/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}
  {{ Html::script('web/assets/global/scripts/datatable.js') }}
  {{ Html::script('web/assets/global/plugins/datatables/datatables.min.js') }} 
  {{ Html::script('web/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }} 
  {{ Html::script('web/assets/pages/scripts/table-datatables-managed.min.js') }}  
  {{ Html::script('web/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}
  {{ Html::script('web/assets/pages/scripts/ui-sweetalert.min.js') }}
  <script>
    function confirmDelete(uri)
    {
      swal({
              title: "{{ ling('you_sure') }}!",
              type: "error",
              confirmButtonClass: "btn-danger",
              confirmButtonText: "{{ ling('yes') }}!",
              showCancelButton: true,
          },
          function() {
             window.location.href = uri;
      });
    }
  </script>
  @if(Session::has('message'))
      <script>
        swal("{{ ling('deleted') }}!", "{{ ling('admin').' '.ling('deleted_succ') }}!", "success");
      </script>
  @endif

  @if(Session::has('success'))
      <script>
        swal("{{ ling('added') }}!", "{{ ling('admin_added_succ') }}!", "success");
      </script>
  @endif

@stop