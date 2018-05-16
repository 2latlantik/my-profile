require('../css/app.scss');

// loads the jquery package from node_modules
var $ = require('jquery');

require('bootstrap');
require('bootstrap-datepicker');

$(document).ready(function() {
    $('.js-datepicker').datepicker({
            format: "dd/mm/yyyy",
            todayBtn: true,
            language: "fr"
    });

    var isAdvancedUpload = function() {
        var div = document.createElement('div');
        return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && 'FormData' in window && 'FileReader' in window;
    }();

    var $form = $('.upload_area');

    if (isAdvancedUpload) {
        $form
            .addClass('has-advanced-upload')
            .on('drag dragstart dragend dragover dragenter dragleave drop', function(e)
            {
                e.preventDefault();
                e.stopPropagation()
            })
            .on('dragover dragenter', function()
            {
                $form.addClass('is-dragover');
            })
            .on('dragleave dragend drop', function()
            {
                $form.removeClass('is-dragover');
            })
            .on('drop', function(e)
            {
                droppedFiles = e.originalEvent.dataTransfer.files;
                uploadFile(droppedFiles);
            });


    }

    var uploadFile = function (droppedFiles) {
        console.log(droppedFiles);
    }
});