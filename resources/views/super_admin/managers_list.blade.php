@extends('layouts.master')
@section('page_title', 'Talent Ranker - '.ling('managers_list'))


@section('content')

	<div class="m-heading-1 border-green m-bordered">
		<h5 style="display: inline-block">Talent Ranker - {{ ling('managers_list') }}!</h5>
		<a href="{{ url('admin_panel/add_manager') }}" class="btn btn-circle green-meadow pull-right"><i class="fa fa-plus"></i> {{ ling('add_new_manager') }}</a>
	</div>
  @php 
    $url_ct = \Request::segment(3); 
    $url_rg = \Request::segment(4);
    $url_og = \Request::segment(5); 
    $cData = get_regions_simp($url_ct);
  @endphp
	<div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-language font-green"></i>
                        <span class="caption-subject font-green bold uppercase"> {{ ling('managers_list') }}</span>
                    </div>
                    <div class="pull-right col-md-8">
                      <form method="GET" action="{{ url('admin_panel/managers_list') }}">
                          <select class="bs-select col-md-3" name="o_id" id="selOrg">
                            @if(count($orgs) > 0)
                              <option value="">{{ ling('org') }}</option>
                              @foreach($orgs as $key => $org)
                              <option value="{{ $org->id }}" {{ ( $org->id == $url_og ) ? 'selected' : '' }}>{{ $org->org_name }}</option>
                              @endforeach
                            @endif
                          </select>
                          <select class="bs-select col-md-3" id="selCot" name="c_id">
                            @if(count(countries()) > 0)
                              <option value="">{{ ling('select_country') }}</option>
                              @foreach(countries() as $key => $country)
                              <option value="{{ $country->id }}" {{ ( $country->id == $url_ct ) ? 'selected' : '' }}>{{ $country->name }}</option>
                              @endforeach
                            @endif
                          </select>
                          <select class="bs-select col-md-3" id="selReg" name="r_id">
                              @if(!empty($url_ct))
                              @foreach($cData as $key => $region)
                                <option value="{{ $region->id }}" {{ ( $region->id == $url_rg ) ? 'selected' : '' }}>{{ $region->name }}</option>
                              @endforeach
                              @endif
                          </select>
                          <button type="submit" class="btn btn-circle green-meadow"><i class="fa fa-filter"></i> Filter</button>
                          <a href="{{ url('admin_panel/managers_list') }}" class="btn btn-circle green-meadow pull-right"><i class="fa fa-refresh"></i> {{ ling('reset') }}</a>
                      </form>
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
                            @if(count($managers) > 0)

                            @foreach($managers as $key => $manager)
                            @if($manager->seen == 0) 
                              @php $seen = '<span class="btn btn-xs yellow">New</span>' @endphp
                            @else
                              {{ $seen = '' }}
                            @endif
                            <tr>
                              <td>{{ $key+1 }}</td>
                              <td>{!! $seen !!}{{ $manager->name }}</td>
                              <td class="font-blue">{{ $manager->country_name }}</td>
                              <td class="font-blue">{{ $manager->region }}</td>
                              <td class="font-yellow">{{ $manager->email }}</td>
                              <td>
                                <a href="{{ url('admin_panel/edit_manager/'.$manager->user_id) }}" class="btn btn-xs green">
                                 {{ ling('edit') }} <i class="fa fa-edit"></i></a>
                                 <a href="javascript:void(0);" onclick="confirmDelete('{{ url('admin_panel/delete_manager/'.$manager->user_id) }}')" class="btn btn-xs red">
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
        swal("{{ ling('deleted') }}!", "{{ ling('manager').' '.ling('deleted_succ') }}!", "success");
      </script>
  @endif
  @if(Session::has('success'))
      <script>
        swal("{{ ling('added') }}!", "{{ ling('added_succ') }}!", "success");
      </script>
  @endif

@stop