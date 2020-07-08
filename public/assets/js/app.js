let app = {
  init: function () {
    console.log("init");
    $("select").change(app.handleSelect);
    setTimeout(function () {
      $(".alert").remove();
    }, 5000);
  },
  handleSelect: function (e) {
    // e.preventDefault();
    var infoObject = {};
    $("select option:selected").each(function () {
      let fieldName = $(this).parent().attr("id");
      infoObject[fieldName] = $(this).text();
    });
    console.log(infoObject);
  },
};
$(app.init);
