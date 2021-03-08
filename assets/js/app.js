const axios = require("axios").default;

let app = {
    init: function () {
        $(".select").change(app.handleSelect);

        setTimeout(function () {
            $(".alert").remove();
        }, 5000);

        $(".city").focus(function () {
            app.handleCityList();
        });

        $(".formSearch").submit(function (e) {
            e.preventDefault();
        });
    },
    searchFormData: { city: null, sport: null },
    handleSelect: function (e) {
        //get select fields data and use it in axios request 
        $(".select option:selected").each(function () {
            let fieldName = $(this).parent().attr("data-name");

            app.searchFormData[fieldName] = $(this).text();
        });
        app.searchRequestUsers(app.searchFormData);
    },
    handleCitySelect: function (value) {

        if (value) {
            app.searchFormData['city'] = value;
            app.searchRequestUsers(app.searchFormData);
        }
    },
    searchRequestUsers: function (data) {
        axios
            .post("/sportresearch", data)
            .then(function (response) {
                app.generateListElement(response);
            })
            .catch(function (error) {
                //if the user is not authenticated 
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
            $cloneContentElements.find('.username').text(value.username)
            $cloneContentElements.find('.age').text(value.age + ' ans')
            $cloneContentElements.find('.user-city').text(value.city)


            //insert template in dom
            $result_container.append($cloneContentElements)

        });
    },
    handleCityList: function () {
        $(".city").autocomplete({
            source: function (request, response) {
                axios({
                    method: 'get',
                    url: "https://api-adresse.data.gouv.fr/search/?city=" + $(".city").val(),
                    params: {
                        q: request.term, limit: 4, importance: 1
                    },
                    responseType: "json"
                })
                    .then(function (data) {
                        var cities = [];
                        response($.map(data.data.features, function (item) {
                            // Ici on est obligé d'ajouter les villes dans un array pour ne pas avoir plusieurs fois la même
                            if ($.inArray(item.properties.postcode, cities) == -1) {
                                cities.push(item.properties.postcode);

                                return {
                                    label: item.properties.city,
                                    city: item.properties.city,
                                    value: item.properties.city
                                };
                            }
                        }));
                    });
            }, minLength: 3,
            select: function (event, ui) {
                app.handleCitySelect(ui.item.value);
            }
        });
    }
};
$(app.init);
