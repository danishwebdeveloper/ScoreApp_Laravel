@extends('layouts.master')
@section('page_title', 'Talent Ranker - '.ling('org'))


@section('content')

	<div class="m-heading-1 border-green m-bordered">
      <span class="caption-subject font-green bold uppercase"> {{ ling('org_detail') }}</span>
		  <a href="{{ url('admin_panel/add_team?org='.$org->id) }}" class="btn btn-circle green-meadow pull-right"><i class="fa fa-plus"></i> {{ ling('add_team') }}</a>
      
      <ul>
        <li><strong>{{ ling('name') }}: </strong>{{ $org->org_name }}</li>
        <li><strong>{{ ling('country') }}: </strong>{{ $org->country }}</li>
        <li><strong>{{ ling('region') }}: </strong>{{ $org->region }}</li>
      </ul>
	</div>


	<div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-language font-green"></i>
                        <span class="caption-subject font-green bold uppercase"> {{ ling('teams') }}</span>
                    </div>
                </div>
                    <table class="table table-hover" id="sample_1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th> {{ ling('name') }} </th>
                                <th> {{ ling('country') }} </th>
                                <th> {{ ling('region') }} </th>
                                <th> {{ ling('city') }} </th>
                                <th> {{ ling('created') }} </th>
                                <th> {{ ling('actions') }} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($teams) > 0)

                            @foreach($teams as $key => $team)
                            @if($team->seen == 0) 
                              @php $seen = '<span class="btn btn-xs yellow">New</span>' @endphp
                            @else
                              {{ $seen = '' }}
                            @endif
                            <tr>
                              <td>{{ $key+1 }}</td>
                              <td><a href="#">{!! $seen !!} {{ $team->team_name }}</a></td>
                              <td class="font-blue">{{ $team->country }}</td>
                              <td class="font-yellow">{{ $team->region }}</td>
                              <td class="font-yellow">{{ $team->city }}</td>
                              <td>{{ Carbon\Carbon::parse($team->created_at)->format('d-m-Y') }}</td>
                              <td>
                                 <a href="javascript:void(0);"  class="btn btn-xs green-meadow">
                                 {{ ling('view') }} <i class="fa fa-eye"></i></a>
                                 <a href="{{ url('admin_panel/edit_team/'.$team->id) }}" class="btn btn-xs green">
                                 {{ ling('edit') }} <i class="fa fa-edit"></i></a>
                                 <a href="javascript:void(0);" onclick="confirmDelete('{{ url('admin_panel/delete_team/'.$team->id) }}')" class="btn btn-xs red">
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
        swal("{{ ling('deleted') }}!", "{{ ling('team').' '.ling('deleted_succ') }}!", "success");
      </script>
  @endif
  @if(Session::has('success'))
      <script>
        swal("{{ ling('added') }}!", "{{ Session::get('success') }}!", "success");
      </script>
  @endif

@stop