@extends('layouts.master')
@section('page_title', 'Talent Ranker - '.ling('exercise_list'))


@section('content')

	<div class="m-heading-1 border-green m-bordered">
		<h5 style="display: inline-block">Talent Ranker - {{ ling('exercise_list') }}!</h5>
		<a href="{{ url('admin_panel/add_exercise') }}" class="btn btn-circle green-meadow pull-right"><i class="fa fa-plus"></i> {{ ling('add_new_exercise') }}</a>
	</div>

	<div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-language font-green"></i>
                        <span class="caption-subject font-green bold uppercase"> {{ ling('add_new_exercise') }}</span>
                    </div>
                </div>
                    <table class="table table-hover" id="sample_1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th> {{ ling('name') }} </th>
                                <th> {{ ling('test').' '.ling('name') }} </th>
                                <th> {{ ling('actions') }} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($exercises) > 0)
                            @foreach($exercises as $key => $exercise)
                            <tr>
                              <td>{{ $key+1 }}</td>
                              <td>{{ $exercise->exercise_name }}</td>
                              <td class="font-blue">{{ $exercise->test_name }}</td>
                              <td>
                                <a href="{{ url('admin_panel/add_points_levels/?e_id='.$exercise->id) }}" class="btn btn-xs blue">
                                 {{ ling('add_points_levels') }} <i class="fa fa-plus"></i></a>
                                 <a href="{{ url('admin_panel/edit_exercise/'.$exercise->id) }}" class="btn btn-xs green">
                                 {{ ling('edit') }} <i class="fa fa-edit"></i></a>
                                 <a href="javascript:void(0);" onclick="confirmDelete('{{ url('admin_panel/delete_exercise/'.$exercise->id) }}')" class="btn btn-xs red">
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
        swal("{{ ling('deleted') }}!", "{{ ling('org').' '.ling('deleted_succ') }}!", "success");
      </script>
  @endif

  @if(Session::has('success'))
      <script>
        swal("{{ ling('added') }}!", "{{ Session::get('success') }}", "success");
      </script>
  @endif
@stop