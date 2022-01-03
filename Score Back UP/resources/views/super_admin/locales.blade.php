@extends('layouts.master')
@section('page_title', 'Talent Ranker - Languages')


@section('content')

	<div class="m-heading-1 border-green m-bordered">
		<h5 style="display: inline-block">Talent Ranker - {{ ling('languages') }}!</h5>
		<button class="btn btn-circle green-meadow pull-right" data-target="#addLang" data-toggle="modal"><i class="fa fa-plus"></i> {{ ling('add_language') }}</button>
	</div>

	<div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-language font-green"></i>
                        <span class="caption-subject font-green bold uppercase">{{ ling('languages_list') }}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    @if(count($locales) > 0)
                    <div class="table">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="10%"> # </th>
                                    <th width="25%"> {{ ling('name') }} </th>
                                    <th width="25%"> {{ ling('locale') }} </th>
                                    <th width="25%"> {{ ling('icon') }} </th>
                                    <th width="25%"> {{ ling('actions') }} </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($locales as $key => $locale)
                                <tr>
                                    <td> {{ $key+1 }} </td>
                                    <td> {{ $locale->name }} </td>
                                    <td> {{ $locale->locale }} </td>
                                    <td> 
                                    	<img alt="" src="{{ asset('web/assets/uploads/assets/'.$locale->icon) }}">
                                    </td>
                                    <td>
                                       <a href="javascript:void(0);" onclick="load_lang('{{ $locale->id }}')" class="btn btn-xs green">{{ ling('edit') }} <i class="fa fa-edit"></i></a>
                                       <a href="javascript:void(0);" onclick="confirmDelete('{{ url('admin_panel/delete_language/'.$locale->id) }}');" class="btn btn-xs red">{{ ling('delete') }} <i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="alert alert-warning">No data found to show...!</p>
                    @endif
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection

@section('style')
  @parent
  {{ Html::style('web/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}
  {{ Html::style('web/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}
@stop

@section('javascript')
  @parent
  {{ Html::script('web/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}
  {{ Html::script('web/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}
  {{ Html::script('web/assets/pages/scripts/ui-sweetalert.min.js') }}
  {{ Html::script('web/assets/requests/trans_script.js') }}
  <script>
    function confirmDelete(uri)
    {
      swal({
              title: "{{ ling('you_sure') }}",
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
        swal("{{ ling('deleted') }}!", "{{ ling('language').' '.ling('deleted_succ') }}", "success");
      </script>
  @endif
@stop