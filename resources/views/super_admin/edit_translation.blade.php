@extends('layouts.master')
@section('page_title', 'Talent Ranker - '.ling('edit_trans'))


@section('content')

	<div class="m-heading-1 border-green m-bordered">
		<h5 style="display: inline-block">Talent Ranker - {{ ling('edit_trans') }}!</h5>
		<a href="{{ url('admin_panel/translations/'.$translation->locale) }}" class="btn btn-circle green-meadow pull-right"><i class="fa fa-reply"></i> {{ ling('go_back') }}</a>
	</div>

	<div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-language font-green"></i>
                        <span class="caption-subject font-green bold uppercase">{{ ling('edit_trans') }}</span>
                    </div>
                </div>
                @if (count($errors->all()) > 0)
                  @foreach ($errors->all() as $error)
                  <p class="alert alert-danger"> {{ $error }} </p>
                  @endforeach
                @endif
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="{{ url('admin_panel/update_translation') }}" class="form-horizontal" method="post">
                      {{ csrf_field() }}
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{ ling('key_value') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" value="{{ $translation->key }}" disabled="disabled" readonly="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                  {{ $translation->locale }}
                                </label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="translation">{{ $translation->translation }}</textarea>
                                </div>
                                <input type="hidden" name="lang_id" value="{{ $translation->id }}">
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-4">
                                    <button type="submit" class="btn green">{{ ling('submit') }}</button>
                                    <a href="{{ url('admin_panel/translations/'.$translation->locale) }}" class="btn default">{{ ling('cancel') }}</a>
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
  {{ Html::style('web/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}
  {{ Html::style('web/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}
  {{ Html::style('web/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}
@stop

@section('javascript')
  @parent

  {{ Html::script('web/assets/pages/scripts/components-bootstrap-select.min.js') }}
  {{ Html::script('web/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }} 
  {{ Html::script('web/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}
  {{ Html::script('web/assets/pages/scripts/ui-sweetalert.min.js') }}
  

  @if(Session::has('message'))
      <script>
        swal("{{ ling('updated') }}!", "{{ ling('translation').' '.ling('updated_succ') }}!", "success");
      </script>
  @endif
@stop