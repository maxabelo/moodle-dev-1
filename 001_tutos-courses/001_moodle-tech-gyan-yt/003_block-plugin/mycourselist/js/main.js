$('#status').on('change', function () {
  const selected_status = this.value;
  $.ajax({
    url: 'http://localhost/campus/blocks/mycourselist/ajax.php',
    data: { selected_status: selected_status },
    type: 'POST',
    success: function (output) {
      $('.resultset').html(output);
    },
  });
});
