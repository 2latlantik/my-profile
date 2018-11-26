
$(document).ready(function() {

    let postAdding = function () {
        $('.js-datepicker').datepicker({
            format: "dd/mm/yyyy",
            todayBtn: true,
            language: "fr"
        });

    };

    let collections = document.getElementsByClassName('collection');
    Array.from(collections).forEach(function(collection) {
        let c = new Collection(collection, postAdding);
        c.buttonDeleteValue = '<i class="fa fa-trash"></i>';
        c.display();
    });

});