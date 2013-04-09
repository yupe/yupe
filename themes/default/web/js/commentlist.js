jQuery(document).ready(function($) {
    $(document).on("click", "a.commentParrent", function() {
        $this = $(this);
        $("div.comment-form").remove();
        var htmlForm = $("#comment-form-wrap").clone();
        htmlForm.addClass("comment-form").show();
        $("#comment-form-wrap").hide();
        $this.parents("div.comment").parent("div").after(htmlForm);
        $("#Comment_level").val(
            parseInt($this.parents("div.comment").parent("div").attr('level'), 0) + 1
        );
        $("#Comment_parent_id").val($this.attr("rel"));
    });
});