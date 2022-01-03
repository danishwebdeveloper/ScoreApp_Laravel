@extends('layouts.master')
@section('page_title', 'Talent Ranker - '.ling('organizations'))


@section('content')

	<div class="m-heading-1 border-green m-bordered">
		<h5 style="display: inline-block">Talent Ranker - {{ ling('org_list') }}!</h5>
	</div>

  @php 
    $url_ct = \Request::segment(3); 
    $url_rg = \Request::segment('4'); 
    $cData = get_regions_simp($url_ct);
  @endphp
  {{ $url_rg }}
	<div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-language font-green"></i>
                        <span class="caption-subject font-green bold uppercase"> {{ ling('organizations') }}</span>
                    </div>
                    <div class="pull-right col-md-6">
                      <form method="GET">
                          <select class="bs-select col-md-5" id="selCot" name="c_id">
                            @if(count(countries()) > 0)
                              <option value="">{{ ling('select_country') }}</option>
                              @foreach(countries() as $key => $country)
                              <option value="{{ $country->id }}" {{ ( $country->id == $url_ct ) ? 'selected' : '' }}>{{ $country->name }}</option>
                              @endforeach
                            @endif
                          </select>
                          <select class="bs-select col-md-5" id="selReg" name="r_id">
                              @if(!empty($url_ct))
                              @foreach($cData as $key => $region)
                                <option value="{{ $region->id }}" {{ ( $region->id == $url_rg ) ? 'selected' : '' }}>{{ $region->name }}</option>
                              @endforeach
                              @endif
                          </select>
                          <button type="button" class="btn btn-circle green-meadow" onclick="submit_filter();"><i class="fa fa-filter"></i> Filter</button>
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
                                <th> {{ ling('actions') }} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($organizations) > 0)

                            @foreach($organizations as $key => $org)
                            <tr>
                              <td>{{ $key+1 }}</td>
                              <td><a href="{{ url('admin/teams?o_id='.$org->id) }}">{{ $org->org_name }}</a></td>
                              <td class="font-blue">{{ $org->country_name }}</td>
                              <td class="font-yellow">{{ $org->region_name }}</td>
                              <td>
                                <a href="{{ url('admin/teams?o_id='.$org->id) }}" class="btn btn-xs green">
                                 {{ ling('view_teams') }} <i class="fa fa-eye"></i></a>
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

  <script>
    function submit_filter()
    {
        var c_id = $('#selCot').val();
        var r_id = $('#selReg').val();
        if(r_id == null)
        {
          r_id = '';
        }
        var url = '{{ url('admin/organizations') }}'
        window.location = url+"/"+c_id+"/"+r_id;
    }
  </script>
@stop