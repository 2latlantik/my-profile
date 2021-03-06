//require('../css/app.scss');

// loads the jquery package from node_modules
const $ = require('jquery');

global.$ = global.jQuery = $;

require('bootstrap');
require('bootstrap-datepicker');
import Quill from 'quill';
import FileSend from './Object/FileSend';
import UploadBlock from './Object/UploadBlock';
import RichText from './Object/RichText';
import RangeInput from './Object/RangeInput';
//var FileSend = require('./Object/FileSend');
//var UploadBlock = require('./Object/UploadBlock');

import Collection from './Object/Collection';
global.Collection = Collection;
import TagsArea from './Object/TagsArea';
global.TagsArea = TagsArea;
global.Quill = Quill;
global.RichText = RichText;
global.RangeInput = RangeInput;

$(document).ready(function() {
    $('.js-datepicker').datepicker({
            format: "dd/mm/yyyy",
            todayBtn: true,
            language: "fr"
    });

    $('[data-toggle="popover"]').popover();

    if(UploadBlock.isAdvancedUpload() === true) {
        let elements = document.getElementsByClassName('upload_area');
        Array.from(elements).forEach(function(child) {
            new UploadBlock(child);
        });
    }
});


/*
var test = new Quill('.editor--container', {
    modules: {
        toolbar: [
            ['bold', 'italic'],
            ['link', 'blockquote', 'code-block', 'image'],
            [{ list: 'ordered' }, { list: 'bullet' }]
        ]
    },
    placeholder: 'Compose an epic...',
    theme: 'snow'
});*/


let richTexts = document.getElementsByClassName('editor--area');
Array.from(richTexts).forEach(function(child) {
    let editorContainer = child.getElementsByClassName('editor--container');
    if(editorContainer.length > 0) {
        let quill = new Quill(editorContainer[0], {
            modules: {
                toolbar: [
                    ['bold', 'italic'],
                    ['link', 'blockquote', 'code-block', 'image'],
                    [{list: 'ordered'}, {list: 'bullet'}]
                ]
            },
            placeholder: 'Compose an epic...',
            theme: 'snow'
        });
        new RichText(child, quill);
        child.dataset.instanciate = 'true';
    }
});

