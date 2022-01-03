@extends('layouts.master')
@section('page_title', 'Talent Ranker - '.ling('add_new_manager'))


@section('content')

	<div class="m-heading-1 border-green m-bordered">
		<h5 style="display: inline-block">Talent Ranker - {{ ling('add_new_manager') }}!</h5>
		<a href="{{ url('admin/managers_list') }}" class="btn btn-circle green-meadow pull-right"><i class="fa fa-reply"></i> {{ ling('go_back') }}</a>
	</div>
	<div class="row">
        <div class="col-md-8">
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-language font-green"></i>
                        <span class="caption-subject font-green bold uppercase">{{ ling('manager_info') }}</span>
                    </div>
                </div>
                @if (count($errors->all()) > 0)
                  @foreach ($errors->all() as $error)
                  <p class="alert alert-danger"> {{ $error }} </p>
                  @endforeach
                @endif
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="{{ url('admin/add_new_manager') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                      {{ csrf_field() }}
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ ling('name') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ ling('email') }}/Username</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ ling('dob') }}</label>
                                <div class="col-md-6">
                                    <select class="form-control bs-select" name="date_of_birth" data-size="7">
                                        <option value="">{{ ling('sel_birth_year') }}</option>
                                        @for($i = 1930; $i <= 2016; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ ling('gender') }}</label>
                                <div class="col-md-6">
                                    <select class="form-control bs-select" name="gender">
                                        <option value="">{{ ling('select_gender') }}</option>
                                        <option value="male">{{ ling('male') }}</option>
                                        <option value="female">{{ ling('female') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ ling('select_country') }}</label>
                                <div class="col-md-6">
                                   <select name="country_id" class="form-control bs-select" id="selCot" data-size="5">
                                     @if(count(countries()) > 0)
                                      <option value="">{{ ling('select_country') }}</option>
                                      @foreach(countries() as $key => $country)
                                      <option value="{{ $country->id }}">{{ $country->name }}</option>
                                      @endforeach

                                     @endif
                                   </select> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ ling('select_region') }}</label>
                                <div class="col-md-6">
                                    <select class="form-control bs-select" name="region_id" id="selReg" data-size="5">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ ling('city') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="city" value="{{ old('city') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ ling('select_org') }}</label>
                                <div class="col-md-6">
                                    <select class="form-control bs-select" name="org" id="seltOrg">
                                        <option value="">{{ ling('select_org') }}</option>
                                        @foreach($orgs as $key => $org)
                                        <option value="{{ $org->id }}">{{ $org->org_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ ling('select_team') }}(s)</label>
                                <div class="col-md-6">
                                    <select class="form-control bs-select" multiple="multiple" name="teams[]" id="seltTeam" data-placeholder="{{ ling('select_team') }}">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-4">
                                    <button type="submit" class="btn green">{{ ling('submit') }}</button>
                                    <a href="{{ url('admin/managers_list') }}" class="btn default">{{ ling('cancel') }}</a>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-language font-green"></i>
                        <span class="caption-subject font-green bold uppercase">{{ ling('manager_info') }}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label">{{ ling('password') }}</label>
                            <input type="password" class="form-control" name="password">
                        </div>

                        <div class="form-group">
                            <label class="control-label">{{ ling('c_password') }}(s)</label>
                            <input type="password" class="form-control" name="c_password">
                        </div>

                        <div class="form-group last">
                          <label class="control-label">{{ ling('user_profile_img') }}</label>
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                              <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                  <img src="http://www.placehold.it/200x200/EFEFEF/AAAAAA&amp;text=no+image" alt="" /> 
                              </div>
                              <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"> </div>
                              <div>
                                  <span class="btn default btn-file">
                                      <span class="fileinput-new"> {{ ling('select_img') }} </span>
                                      <span class="fileinput-exists"> {{ ling('change') }} </span>
                                      <input type="file" name="user_image"> 
                                  </span>
                                  <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> {{ ling('remove') }} </a>
                              </div>
                          </div>
                        </div>
                    </div>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
        </form>
    </div>

@endsection

@section('style')
  @parent
  {{ Html::style('web/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}
  {{ Html::style('web/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}
  {{ Html::style('web/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}
  {{ Html::style('web/assets/global/plugins/select2/css/select2.min.css') }}
  {{ Html::style('web/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}
  {{ Html::style('web/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}
@stop

@section('javascript')
  @parent

  {{ Html::script('web/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}
  {{ Html::script('web/assets/pages/scripts/ui-sweetalert.min.js') }}
  {{ Html::script('web/assets/global/plugins/select2/js/select2.full.min.js') }}
  {{ Html::script('web/assets/pages/scripts/components-select2.min.js') }}
  {{ Html::script('web/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}



  @if(Session::has('message'))
      <script>
        swal("{{ ling('added') }}!", "{{ ling('added_succ') }}!", "success");
      </script>
  @endif

  @if(Session::has('error'))
      <script>
        swal("{{ ling('error') }}!", "{{ ling('email_already_exist') }}!", "error");
      </script>
  @endif
@stop