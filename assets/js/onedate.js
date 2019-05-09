
$(document).ready(function() {




  $('.js-datepicker').datepicker({
  format: 'yyyy-mm-dd',
    setDate: new Date(),
    startDate:new Date(),
    autoclose: true
  
  });
  $('.js-datepicker').datepicker('setDate', 'now');



  });
