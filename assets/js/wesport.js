const axios = require("axios").default;

let app = {
    init: function () {
        console.log("init");

        $(".select").change(app.handleSelect);
        $(".departement").change(app.handleCityList);

        setTimeout(function () {
            $(".alert").remove();
        }, 5000);
    },
    handleSelect: function (e) {
        //get select fields data and use it in axios request 
        var data = {};
        $(".select option:selected").each(function () {
            let fieldName = $(this).parent().attr("data-name");

            if ($(this).text() == 'Ville' || $(this).text() == 'Selectionner votre ville' || $(this).text() == 'Sport' || $(this).text() == 'Niveau') {
                data[fieldName] = null;
            } else {
                data[fieldName] = $(this).text();
            }
        });
        app.searchRequestUsers(data);
    },
    searchRequestUsers: function (data) {
        ;
        axios
            .post("/sportresearch", data)
            .then(function (response) {
                console.log(response.data)
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
            $cloneContentElements.find('#username').text(value.username)
            $cloneContentElements.find('#age').text(value.age + ' ans')
            $cloneContentElements.find('#city').text(value.city)
            if (value.profileImage) {
                $cloneContentElements.find('.search-image').attr('src', 'uploads/usersProfileImages/' + value.profileImage);
            }

            //insert template in dom
            $result_container.append($cloneContentElements)

        });
    },
    handleCityList: function () {
        axios
            .post("/sportresearch/get-city-list", { 'departmentCode': $(".departement").val() })
            .then(function (response) {
                app.fillFormField(response);
            })
            .catch(function (error) {
                //if  API server returned error
                if (error.response.data.status == 500) {
                    let $section = $("#search_section");
                    $section.append('<p class= "alert alert-warning">un problème est survenue relancer la recherche</p>');

                }

            });
    },
    fillFormField: function (response) {
        $(".city option").remove(); //reset previous result of select field
        $('.city').prop("disabled", false); //field city select activation

        $('.city').append('<option>Selectionner votre ville</option>');
        $.each(response.data.cityList, function (key, value) {

            $('.city').append('<option value="' + value.nom + '">' + value.nom + '</option>');
        });
    }
};
$(app.init);
