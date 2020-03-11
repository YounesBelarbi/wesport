let app = {
    init: function () {
        console.log('app')

        let $formElement = $('form');
        $formElement.on('submit', app.handleSubmitSearchForm);
    },
    handleSubmitSearchForm: function (evt) {
        evt.preventDefault();

        
        let $formElement = $('form');
        $age = $("#sport_research_age").val();
        $city = $("#sport_research_city").val();
        $sport = $("#sport_research_sport").val();
        $level = $("#sport_research_level").val();

        let xhr = $.ajax(
            {
              url: 'http://localhost:8001/user/sportresearch/requete',
              method: 'POST',
              dataType: 'json',
              data: {
                  'age':$age,
                  'city': $city,
                  'sport': $sport,
                  'level': $level
              }
            }
            
          );
      
          
          xhr.done(
            function(response) {
              console.log('envoyé');

           app.generateListElement(response);

            }
            );
            
            xhr.fail(
              function() {
                alert('Ajax failed');
              }
              );          
              
            },
    generateListElement: function(response) {

      $section = $("#result_section");

      //deletion of previous results
      $section.find('.container').remove()

      let $templateElement = $("#templateResult");
      let $contentElements = $templateElement.contents();
      
      $.each(response, function (key, value) {

        //clone template
        let $cloneContentElements = $contentElements.clone();

        
        // filling the template with the information
        $cloneContentElements.find('#username').text(value.username)
        $cloneContentElements.find('#age').text(value.age+' ans')
        $cloneContentElements.find('#city').text(value.city)
        
        //insert template in dom
        $section.append($cloneContentElements)

      })
    }  




}
$(app.init);