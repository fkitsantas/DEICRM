$(document).ready(function () {
  $('.hideclass').hide();

    $("#task_form_RelatedToType").change(function () {
      $('#option').hide();
        var val = $(this).val();
        if (val == "") {
          $("[id=option]").show();

        }
        else {
            $("[id=option]").hide();
        }
        if (val == "Account") {
          $("[id=account]").show();
          $('#account').attr('name', 'RelatedTo');
        var selected = $("#account option:selected").text();
          $('#RelatedToValue').val(selected);
        }
        else {
            $("[id=account]").hide();
            $('#account').attr('name', '');

        }

        if (val == "Contact") {

          $("[id=contact]").show();
          $('#contact').attr('name', 'RelatedTo');
          var selected = $("#contact option:selected").text();
            $('#RelatedToValue').val(selected);
        }
        else {
            $("[id=contact]").hide();
            $('#contact').attr('name', '');

        }

       if (val == "Lead")
       {
         $("[id=leads]").show();
         $('#leads').attr('name', 'RelatedTo');
         var selected = $("#leads option:selected").text();
           $('#RelatedToValue').val(selected);
       }
       else {
           $("[id=leads]").hide();
           $('#leads').attr('name', '');
       }

         if (val == "Opportunity") {

        $("[id=opportunities]").show();
        $('#opportunities').attr('name', 'RelatedTo');
        var selected = $("#opportunities option:selected").text();
          $('#RelatedToValue').val(selected);

        }
        else {
          $("[id=opportunities]").hide();
          $('#opportunities').attr('name', '');
        }

       if (val == "Target") {

       $("[id=target]").show();
       $('#target').attr('name', 'RelatedTo');
       var selected = $("#target option:selected").text();
         $('#RelatedToValue').val(selected);

       }
       else {
         $("[id=target]").hide();
         $('#target').attr('name', '');
        }
       if (val == "Task") {

          $("[id=tasks]").show();
          $('#tasks').attr('name', 'RelatedTo');
          var selected = $("#tasks option:selected").text();
            $('#RelatedToValue').val(selected);
        }

        else {
          $("[id=tasks]").hide();
          $('#tasks').attr('name', '');
        }
    });
});
