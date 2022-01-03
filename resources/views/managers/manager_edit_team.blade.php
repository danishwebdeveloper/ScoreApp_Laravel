@extends('layouts.master')
@section('page_title', 'Talent Ranker - '.ling('edit').' '.ling('team'))


@section('content')

	<div class="m-heading-1 border-green m-bordered">
		<h5 style="display: inline-block">Talent Ranker - {{ ling('edit').' '.ling('team') }}!</h5>
		<a href="{{ url('manager/teams') }}" class="btn btn-circle green-meadow pull-right"><i class="fa fa-reply"></i> {{ ling('go_back') }}</a>
	</div>
  @php 
    $cData = get_regions_simp($team_data->country_id);
  @endphp
	<div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-language font-green"></i>
                        <span class="caption-subject font-green bold uppercase">{{ ling('edit').' '.ling('team') }}</span>
                    </div>
                </div>
                @if (count($errors->all()) > 0)
                  @foreach ($errors->all() as $error)
                  <p class="alert alert-danger"> {{ $error }} </p>
                  @endforeach
                @endif
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="{{ url('manager/update_team') }}" class="form-horizontal" method="post">
                      {{ csrf_field() }}
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ ling('name') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value="{{ $team_data->team_name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ ling('org') }}</label>
                                <div class="col-md-6">
                                    <select class="form-control bs-select" data-size="5" disabled="">
                                        <option>{{ $org->org_name }}</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="org_id" value="{{ $org->id }}">
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ ling('select_country') }}</label>
                                <div class="col-md-6">
                                   <select name="country_id" class="form-control bs-select" id="selCot" data-size="5">
                                     @if(count(countries()) > 0)
                                      <option value="">{{ ling('select_country') }}</option>
                                      @foreach(countries() as $key => $country)
                                      <option value="{{ $country->id }}" {{ ( $country->id == $team_data->country_id ) ? 'selected' : '' }}>{{ $country->name }}</option>
                                      @endforeach

                                     @endif
                                   </select> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ ling('select_region') }}</label>
                                <div class="col-md-6">
                                    <select class="form-control bs-select" name="region_id" id="selReg" data-size="5">
                                      @foreach($cData as $key => $region)
                                        <option value="{{ $region->id }}" {{ ( $region->id == $team_data->region_id ) ? 'selected' : '' }}>{{ $region->name }}</option>
                                      @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-4">
                                    <input type="hidden" name="team_id" value="{{ $team_data->id }}">
                                    <button type="submit" class="btn green">{{ ling('submit') }}</button>
                                    <a href="{{ url('manager/teams') }}" class="btn default">{{ ling('cancel') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>

@endsection

@section('style')
  @parent
  {{ Html::style('web/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}
  {{ Html::style('web/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}
@stop

@section('javascript')
  @parent

  {{ Html::script('web/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}
  {{ Html::script('web/assets/pages/scripts/ui-sweetalert.min.js') }}

  @if(Session::has('message'))
      <script>
        swal("{{ ling('updated') }}!", "{{ ling('team').' '.ling('updated_succ') }}!", "success");
      </script>
  @endif
@stop