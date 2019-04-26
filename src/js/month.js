$(document).ready(function() {
    $('#months').on('change', function() {
        var month = $('#months').val();
        console.log(month)
        alert( this.value );
      })
});