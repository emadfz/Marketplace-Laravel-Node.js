<div class="form-body">
    <div class="form-group {!! $errors->has('topic_name') ? 'has-error' : '' !!}">
        <label class="control-label">{{ trans("form.faq.topic_name")}}</label>
        <input type="text" class="form-control" name='topic_name' value="{{ isset($id) ? $faqTopicData[0]['topic_name'] : ''}}" />
        {!! $errors->first('topic_name', '<span class="help-block">:message</span>') !!}
    </div>
</div>

<div class="portlet-title">
    <div class="caption">
        <i class="icon-equalizer font-blue-hoki"></i>
        <span class="caption-subject font-blue-hoki bold uppercase">{{ isset($id) ? trans("form.faq.edit_question_answer") : trans("form.faq.create_question_answer") }}</span>
    </div>
    <!--<div class="tools">
        <a href="" class="collapse"> </a>
        <a href="#portlet-config" data-toggle="modal" class="config"> </a>
        <a href="" class="reload"> </a>
        <a href="" class="remove"> </a>
    </div>-->
</div>

<div class="table">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>Question</th>
                <th>Answer</th>
                <th>
                    <a href="javascript:;" class="btn sbold default" id="add_question_answer">Add &nbsp;<i class="fa fa-plus"></i></a>
                </th>
            </tr>
        </thead>
        <tbody id="question_answer_list">
            <?php $iCounter = isset($id) ? count($faqTopicData[0]['faqs']) : 1; ?>
        <input type="hidden" value="{{ $iCounter }}" name="faq_row_counter" />
        <?php $i = 1; ?>

        @foreach ($faqTopicData[0]['faqs'] as $faq)
        <?php $currentFaqId = encrypt($faq['id']); ?>
        <tr>
            <td><textarea name="faq[{{$i}}][question]" class="form-control faq.{{$i}}.question" data-fieldtype="question">{{$faq['question']}}</textarea></td>
            <td><textarea name="faq[{{$i}}][answer]" class="form-control faq.{{$i}}.answer" data-fieldtype="answer">{{$faq['answer']}}</textarea></td>
            <td>
                @if($i != 1)
                <a href="javascript:void(0)" 
                   class="btn btn-danger btn-xs fa fa-trash-o deleteFaq" 
                   data-toggle="modal" data-placement="top" title="Delete" 
                   data-faq_delete_remote="{{ route(config('project.admin_route').'faq.destroy', $currentFaqId) }}">
                </a>
                @endif
                
                <input type="hidden" value="{{ $currentFaqId }}" name="faq[{{ $i }}][id]" data-fieldtype="hdnCurrentFaqId"/>
            </td>
        </tr>
        <?php $i++; ?>
        @endforeach

        </tbody>
    </table>
</div>

<div class="form-actions">
    <div class="btn-set pull-left">
        <!--<button type="submit" class="btn green">Submit</button>
        <button type="button" class="btn blue">Other Action</button>-->
        {!! Form::submit(isset($id) ? trans("form.update") : trans("form.save"), ['class'=>'btn btn-primary']) !!}
        <a class="btn default" href="{{route(config('project.admin_route').'faq.index')}}">{{trans("form.cancel")}}</a>
    </div>
</div>

<!-- Modal Dialog -->
<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{trans("form.faq.delete_faq")}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('message.faq.are_you_sure_delete_faq')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('form.cancel')}}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteFaq">{{trans('form.delete')}}</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    var inner_html = "";
    $("#add_question_answer").on("click", function () {
        var current_faq_row_counter = parseInt($("input[name=faq_row_counter]").val());
        var faq_row_counter = current_faq_row_counter + 1;
        $("input[name=faq_row_counter]").val(faq_row_counter);
        inner_html = '<tr>' +
                '<td><textarea name="faq[' + faq_row_counter + '][question]" class="form-control faq.' + faq_row_counter + '.question" data-fieldtype="question"></textarea></td>' +
                '<td><textarea name="faq[' + faq_row_counter + '][answer]" class="form-control faq.' + faq_row_counter + '.answer" data-fieldtype="answer"></textarea></td>' +
                '<td><a href="javascript:void(0)" class="btn btn-danger btn-xs fa fa-trash-o deleteTempFaq" title="{{ trans("form.delete") }}"></a></td>' +
                '</tr>';

        $("#question_answer_list").append(inner_html);
    });


    //$(document).ready(function () {
    var faqDeleteUrl = '';
    var currentRow = '';
    $("#question_answer_list").on("click", ".deleteFaq", function (e) {
        e.preventDefault();
        $('#confirmDelete').modal('show');
        faqDeleteUrl = $(this).data('faq_delete_remote');
        currentRow = $(this);
    });

    $("#question_answer_list").on("click", ".deleteTempFaq", function (e) {
        $(this).closest("tr").remove();
        decreaseRowCounter();
    });

    $('#confirmDeleteFaq').on('click', function (e) {
        $.ajax({
            url: faqDeleteUrl,
            type: 'DELETE',
            dataType: 'json',
            data: {method: '_DELETE', submit: true},
            success: function (r) {
                if (r.success == 1) {
                    $('#confirmDelete').modal('hide');
                    //oTable.draw(false);
                    currentRow.closest("tr").remove();
                    decreaseRowCounter();
                    toastr.success(r.msg);
                } else if (r.success == 0) {
                    toastr.error(r.msg, "{{ trans('message.failure') }}", {timeOut: 10000});
                    $('#confirmDelete').modal('hide');
                }
            },
            error: function (data) {
                if (data.status === 422) {
                    toastr.error("{{ trans('message.failure') }}");
                }
            }
        });
    });

    function decreaseRowCounter() {
        var current_faq_row_counter = parseInt($("input[name=faq_row_counter]").val());
        var faq_row_counter = current_faq_row_counter - 1;
        $("input[name=faq_row_counter]").val(faq_row_counter);
        faqRowNameUpdate();
    }

    function faqRowNameUpdate() {
        var tmp_row_counter = 1;
        var tmp_td_textarea = "";
        
        $("tbody#question_answer_list tr").each(function () {
            
            $(this).find("td").each(function () {
                
                tmp_td_textarea = $(this).find("textarea");
                
                if (tmp_td_textarea.data("fieldtype") == 'question') {
                    tmp_td_textarea.attr("name", "faq[" + tmp_row_counter + "][question]")
                            .removeAttr("class").addClass("form-control faq." + tmp_row_counter + ".question");
                } else if (tmp_td_textarea.data("fieldtype") == 'answer') {
                    tmp_td_textarea.attr("name", "faq[" + tmp_row_counter + "][answer]")
                            .removeAttr("class").addClass("form-control faq." + tmp_row_counter + ".answer");
                } else {
                    $(this).find("input[type=hidden]").attr("name", "faq[" + tmp_row_counter + "][id]");
                }
            });

            tmp_row_counter++;
        });
    }
</script>
@endpush