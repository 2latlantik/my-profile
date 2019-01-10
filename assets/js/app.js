require('../css/app.scss');

// loads the jquery package from node_modules
var $ = require('jquery');

require('bootstrap');
require('bootstrap-datepicker');
import FileSend from './Object/FileSend';
import UploadBlock from './Object/UploadBlock';
//var FileSend = require('./Object/FileSend');
//var UploadBlock = require('./Object/UploadBlock');

import Collection from './Object/Collection';
global.Collection = Collection;
import TagsArea from './Object/TagsArea';
global.TagsArea = TagsArea;

$(document).ready(function() {
    $('.js-datepicker').datepicker({
            format: "dd/mm/yyyy",
            todayBtn: true,
            language: "fr"
    });

    if(UploadBlock.isAdvancedUpload() === true) {
        let elements = document.getElementsByClassName('upload_area');
        Array.from(elements).forEach(function(child) {
            new UploadBlock(child);
        });
    }


});


