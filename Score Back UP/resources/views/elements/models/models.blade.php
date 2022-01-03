<!-- SET USER DEFAULT LANGUAGE MODEL BOX -->
<div id="defLang" class="modal fade" tabindex="-1" data-focus-on="input:first">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">{{ ling('change_default_language') }}</h4>
    </div>
    <div class="modal-body">
        <form id="">
            <div class="form-group">
                <label>{{ ling('language_name') }}:</label>
                <select class="bs-select form-control col-md-4" id="defLocal">

                    @if(count(load_languages()) > 0)

                    @foreach(load_languages() as $key => $locale)
                    <option value="{{ $locale->locale }}">{{ $locale->name }}</option>
                    @endforeach

                    @endif
                </select>
            </div>
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-outline dark">{{ ling('close') }}</button>
        <button type="button" id="defLangBtn" onclick="(user_default_lang($('#defLocal').val()));" class="btn green">{{ ling('update') }}</button>
    </div>
    </form>
</div>

<!-- END SET USER DEFAULT LANGUAGE MODEL BOX -->
<!-- ======================================= -->

<!-- Super Admin Models -->
@if(Auth::user()->isSuperAdmin())
    @if(Request::is('admin_panel/locales'))
    <!-- ADD LANGUAGE MODEL BOX (PAGE: locales) -->
    <div id="addLang" class="modal fade" tabindex="-1" data-focus-on="input:first">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" id="LangClsBtn" aria-hidden="true"></button>
            <h4 class="modal-title">{{ ling('add_language') }}</h4>
        </div>
        <div class="modal-body">
            <div id="errCnt"></div>
            <form id="addNewLang" method="post" action="{{ url('admin_panel/add_language') }}" enctype="multipart/form-data">
                <div class="form-group">
                    <label>{{ ling('language_name') }}:</label>
                    <input class="form-control" type="text" name="name" placeholder="e.g English"> 
                </div>
                <div class="form-group">
                    <label>{{ ling('locale_name') }}:</label>
                    <input class="form-control" type="text" name="locale" placeholder="e.g en">
                </div>
                <div class="form-group">
                    <label>{{ ling('copy_trans_from') }}</label>
                    <select class="form-control bs-select" name="copy_locale">
                        @foreach($locales as $key => $locale)
                        <option value="{{ $locale->locale }}">{{ $locale->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>{{ ling('locale_icon') }}:</label>
                    <div>
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="input-group input-large">
                                <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                    <span class="fileinput-filename"> </span>
                                </div>
                                <span class="input-group-addon btn default btn-file">
                                    <span class="fileinput-new"> {{ ling('select_file') }} </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" name="icon"> </span>
                                <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                            </div>
                        </div>
                    </div>
                <span class="caption-helper font-red small">*{{ ling('add_local_icon_help') }}.</span>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-outline dark">{{ ling('close') }}</button>
            <button type="submit" id="langBtn" class="btn green">{{ ling('add_language') }}</button>
        </div>
        </form>
    </div>
    <!-- END ADD LANGUAGE MODEL BOX -->

    <!-- ADD LANGUAGE MODEL BOX (PAGE: locales) -->
    <div id="editLang" class="modal fade" tabindex="-1" data-focus-on="input:first">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" id="LangClsBtnUp" aria-hidden="true"></button>
            <h4 class="modal-title">{{ ling('edit').' '.ling('language') }}</h4>
        </div>
        <div class="modal-body">
            <div id="errCntUp"></div>
            <form id="editLangFrm" method="post" action="{{ url('admin_panel/update_language') }}" enctype="multipart/form-data">
                <div class="form-group">
                    <label>{{ ling('language_name') }}:</label>
                    <input class="form-control" id="langName" type="text" name="name" placeholder="e.g English"> 
                </div>
                <div class="form-group">
                    <label>{{ ling('locale_name') }}:</label>
                    <input class="form-control" id="langLoc" type="text" name="locale" placeholder="e.g en">
                </div>
                <div class="form-group">
                    <label>{{ ling('locale_icon') }}:</label>
                    <img id="locIcon" src="{{ asset('web/assets/uploads/assets/1508771048.png') }}">
                    <div>
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="input-group input-large">
                                <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                    <span class="fileinput-filename"> </span>
                                </div>
                                <span class="input-group-addon btn default btn-file">
                                    <span class="fileinput-new"> {{ ling('select_file') }} </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" id="langIco" name="icon"> 
                                </span>
                                <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                            </div>
                        </div>
                    </div>
                    <span class="caption-helper font-red small">*{{ ling('add_local_icon_help') }}.</span>
                    <input type="hidden" name="lang_id" id="langId">
                    <input type="hidden" name="pre_icon" id="langPreIco">
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-outline dark">{{ ling('close') }}</button>
            <button type="submit" id="langBtnUp" class="btn green">{{ ling('update_language') }}</button>
        </div>
        </form>
    </div>
    <!-- END ADD LANGUAGE MODEL BOX -->
    @endif
@endif