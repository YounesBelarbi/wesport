/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

import wesport from "./wesport.js";

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
