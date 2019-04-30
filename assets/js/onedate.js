
$(document).ready(function() {




$('.js-datepicker').datepicker({
format: 'yyyy-MM-dd',
  setDate: new Date(),
  startDate:new Date(),
  autoclose: true

});
$('.js-datepicker').datepicker('setDate', 'now');



});
