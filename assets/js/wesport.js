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
        var data = {};
        $("select option:selected").each(function () {
            let fieldName = $(this).parent().attr("data-name");
            data[fieldName] = $(this).text();
        });
        console.log(data);
        app.searchRequestUsers(data);

    },
    searchRequestUsers: function (data) {
        axios
            .post("/sportresearch", data)
            .then(function (response) {
                app.generateListElement(response);
            })
            .catch(function (error) {
                if (error.response.status == 403) {
                    location.href = '/login';
                }
            });
    },
    generateListElement: function (response) {
        let $section = $("#result_section");

        // deletion of previous results
        let $result_container = $section.find('.container');
        $result_container.contents().remove();

        let $templateElement = $("#templateResult");
        let $contentElements = $templateElement.contents();

        let $result = response.data;
        let resultNumber = $result.length;
        $result_container.append("<div class='d-flex justify-content-between m-4 row'><h2  class='search-title'> il y a " + resultNumber + " résultat pour votre recherche</h2></div>");

        $.each(response.data, function (key, value) {

            //clone template
            let $cloneContentElements = $contentElements.clone();
            // filling the template with the information
            $cloneContentElements.find('#username').text(value.username)
            $cloneContentElements.find('#age').text(value.age + ' ans')
            $cloneContentElements.find('#city').text(value.city)

            //insert template in dom
            $result_container.append($cloneContentElements)

        });
    }
};
$(app.init);
