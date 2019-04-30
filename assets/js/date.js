
$(document).ready(function() {



  $('.js-datepicker1').datepicker({
  format: 'yyyy-MM-dd',
    setDate: new Date(),
    startDate:new Date(),
    autoclose: true

  });
$('.js-datepicker1').datepicker('setDate', 'now');


$('.js-datepicker2').datepicker({
format: 'yyyy-MM-dd',
  setDate: new Date(),
  startDate:new Date(),
  autoclose: true

});
$('.js-datepicker2').datepicker('setDate', 'now');



});
