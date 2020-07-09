const axios = require("axios").default;

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
            let fieldName = $(this).parent().attr("data-name");
            infoObject[fieldName] = $(this).text();
        });
        console.log(infoObject);
        app.searchRequestUsers(infoObject);
    },
    searchRequestUsers: function (infoObject) {
        axios
            .post("/user/sportresearch", infoObject)
            .then(function (response) {
                console.log(response.data);
            })
            .catch(function (error) {
                console.log(error.response);
            });
    },
};
$(app.init);
