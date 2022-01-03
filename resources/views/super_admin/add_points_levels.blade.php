@extends('layouts.master')
@section('page_title', 'Talent Ranker - '.ling('add_new_exercise'))


@section('content')

	<div class="m-heading-1 border-green m-bordered">
		<h5 style="display: inline-block">Talent Ranker - {{ ling('add_new_exercise') }}!</h5>
		<a href="{{ url('admin_panel/exercises') }}" class="btn btn-circle green-meadow pull-right"><i class="fa fa-reply"></i> {{ ling('go_back') }}</a>
	</div>
	<div class="row">
        <div class="col-md-6">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-speech font-green"></i>
                        <span class="caption-subject bold font-green uppercase">User Profile</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <form role="form" action="" method="get">
                        <div class="form-group">
                            <label class="control-label">Select Test</label>
                            <select class="form-control bs-select">
                              <option>Value</option>
                              <option>Value</option>
                              <option>Value</option>
                            </select>    
                        </div>
                        <div class="form-group">
                            <label class="control-label">Select Exercise</label>
                            <select class="form-control bs-select">
                              <option>Value</option>
                              <option>Value</option>
                              <option>Value</option>
                            </select>    
                        </div>
                        <div class="form-group">
                            <label class="control-label">Select Gender</label>
                            <select class="form-control bs-select">
                              <option>Value</option>
                              <option>Value</option>
                              <option>Value</option>
                            </select>    
                        </div>
                        <div class="margin-top-10">
                            <button type="submit" class="btn green">Add Points Levels</button>
                            <a href="javascript:;" class="btn default">Cancel </a>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-speech font-green"></i>
                        <span class="caption-subject bold font-green uppercase">Product Inventory</span>
                    </div>
                </div>
                <div class="portlet-body form form-horizontal">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Product Variation</label>
                            <div class="col-md-9">
                                <div class="mt-repeater">
                                    <div data-repeater-list="group-b">
                                        <div data-repeater-item class="row">
                                            <div class="col-md-7">
                                                <label class="control-label">Name</label>
                                                <input type="text" placeholder="Salted Tuna" class="form-control" /> </div>
                                            <div class="col-md-3">
                                                <label class="control-label">Qty</label>
                                                <input type="text" placeholder="3" class="form-control" /> </div>
                                            <div class="col-md-1">
                                                <label class="control-label">&nbsp;</label>
                                                <a href="javascript:;" data-repeater-delete class="btn btn-danger">
                                                    <i class="fa fa-close"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <a href="javascript:;" data-repeater-create class="btn btn-info mt-repeater-add">
                                        <i class="fa fa-plus"></i> Add Variation</a>
                                    <br>
                                    <br> </div>
                            </div>
                        </div>
                    </form>
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

  {{ Html::script('web/assets/global/plugins/jquery-repeater/jquery.repeater.js') }}
  {{ Html::script('web/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}
  {{ Html::script('web/assets/pages/scripts/form-repeater.min.js') }}
  {{ Html::script('web//assets/pages/scripts/components-date-time-pickers.min.js') }}

@stop