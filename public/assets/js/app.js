let app = {
  init: function () {
    console.log("init");
    setTimeout(function () {
      $(".alert").remove();
    }, 5000);
  },
};
$(app.init);
