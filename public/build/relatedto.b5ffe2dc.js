(window.webpackJsonp=window.webpackJsonp||[]).push([["relatedto"],{x4zJ:function(t,e,a){(function(t){t(document).ready(function(){t(".hideclass").hide(),t("#task_form_RelatedToType").change(function(){t("#option").hide();var e=t(this).val();if(""==e?t("[id=option]").show():t("[id=option]").hide(),"Account"==e){t("[id=account]").show(),t("#account").attr("name","RelatedTo");var a=t("#account option:selected").text();t("#RelatedToValue").val(a)}else t("[id=account]").hide(),t("#account").attr("name","");if("Contact"==e){t("[id=contact]").show(),t("#contact").attr("name","RelatedTo");a=t("#contact option:selected").text();t("#RelatedToValue").val(a)}else t("[id=contact]").hide(),t("#contact").attr("name","");if("Lead"==e){t("[id=leads]").show(),t("#leads").attr("name","RelatedTo");a=t("#leads option:selected").text();t("#RelatedToValue").val(a)}else t("[id=leads]").hide(),t("#leads").attr("name","");if("Opportunity"==e){t("[id=opportunities]").show(),t("#opportunities").attr("name","RelatedTo");a=t("#opportunities option:selected").text();t("#RelatedToValue").val(a)}else t("[id=opportunities]").hide(),t("#opportunities").attr("name","");if("Target"==e){t("[id=target]").show(),t("#target").attr("name","RelatedTo");a=t("#target option:selected").text();t("#RelatedToValue").val(a)}else t("[id=target]").hide(),t("#target").attr("name","");if("Task"==e){t("[id=tasks]").show(),t("#tasks").attr("name","RelatedTo");a=t("#tasks option:selected").text();t("#RelatedToValue").val(a)}else t("[id=tasks]").hide(),t("#tasks").attr("name","")})})}).call(this,a("EVdn"))}},[["x4zJ","runtime",0]]]);