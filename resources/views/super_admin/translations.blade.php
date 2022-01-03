@extends('layouts.master')
@section('page_title', 'Talent Ranker - '.ling('translations'))


@section('content')

	<div class="m-heading-1 border-green m-bordered">
		<h5 style="display: inline-block">Talent Ranker - {{ ling('lang_translations') }}!</h5>
		<a href="{{ url('admin_panel/add_translations') }}" class="btn btn-circle green-meadow pull-right"><i class="fa fa-plus"></i> {{ ling('add_new_trans') }}</a>
    <div class="col-md-2 pull-right">
      @php 
        $url_segment = \Request::segment(3); 
      @endphp
      <select class="bs-select form-control" id="changeLocal">
          @if(count($locales) > 0)

          @foreach($locales as $key => $locale)
          <option value="{{ url('admin_panel/translations/'.$locale->locale) }}" {{ ( $locale->locale == $url_segment ) ? 'selected' : '' }}>{{ $locale->name }}</option>
          @endforeach

          @endif
      </select>
    </div>
	</div>

	<div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-language font-green"></i>
                        <span class="caption-subject font-green bold uppercase"> {{ ling('translations') }}</span>
                    </div>
                    
                </div>
                    <table class="table table-hover" id="sample_1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th> {{ ling('locale') }} </th>
                                <th> {{ ling('key') }} </th>
                                <th> {{ ling('translations') }} </th>
                                <th> {{ ling('actions') }} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($translations) > 0)

                            @foreach($translations as $key => $trans)
                            <tr>
                              <td>{{ $key+1 }}</td>
                              <td>{{ $trans->locale }}</td>
                              <td class="font-blue">{{ $trans->key }}</td>
                              <td class="font-yellow">{{ $trans->translation }}</td>
                              <td>
                                <a href="{{ url('admin_panel/edit_translation/'.$trans->id) }}" class="btn btn-xs green">
                                 {{ ling('edit') }} <i class="fa fa-edit"></i></a>
                                 <a href="javascript:void(0);" onclick="confirmDelete('{{ url('admin_panel/delete_translation/'.$trans->id) }}')" class="btn btn-xs red">
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
        swal("{{ ling('deleted') }}!", "{{ ling('translation').' '.ling('deleted_succ') }}!", "success");
      </script>
  @endif

  <script>
    $("#changeLocal").change(function () {
        location.href = $(this).val();
    })
  </script>
@stop