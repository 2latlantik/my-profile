

$(document).ready(function() {

    let postAdding = function () {
        $('.js-datepicker').datepicker({
            format: "dd/mm/yyyy",
            todayBtn: true,
            language: "fr"
        });
        let richTexts = document.getElementsByClassName('editor--area');
        Array.from(richTexts).forEach(function(child) {
            let editorContainer = child.getElementsByClassName('editor--container');
            if(editorContainer.length > 0 && child.dataset.instanciate !== 'true') {
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
    };

    let postAdding2 = function () {
        let collections = document.getElementsByClassName('collection--skills');
        Array.from(collections).forEach(function(collection) {
            if(collection.dataset.instanciate !== 'true') {
                let config = [];
                config['post_adding'] = postAddingItem;
                config['button_delete_value'] = '<i class="fa fa-trash"></i>';
                config['collection__item'] = 'skill--item';
                let c = new Collection(collection, config);
                c.display();
            }
        });
    };

    let postAddingItem = function () {
        let rangeInputs = this.collection.getElementsByClassName('range--input');
        Array.from(rangeInputs).forEach(function(child) {
            if(child.dataset.instanciate !== 'true') {
                new RangeInput(child);
            }
        });
        evaluatedInputs();
    };

    let collections = document.getElementsByClassName('collection');
    Array.from(collections).forEach(function(collection) {
        let config = [];
        config['post_adding'] = postAdding;
        config['button_delete_value'] = '<i class="fa fa-trash"></i>';
        let c = new Collection(collection, config);
        c.display();
    });


    let tagsArea = document.getElementsByClassName('tags--area');
    Array.from(tagsArea).forEach(function(child) {
        new TagsArea(child);
    });

    let tagsInput = document.getElementsByClassName('tags--input');
    Array.from(tagsInput).forEach(function(child) {
        child.classList.remove('form-control');
    });

    let collectionsSkillGroups = document.getElementsByClassName('collection--skillGroups');
    Array.from(collectionsSkillGroups).forEach(function(collection) {
        let config = [];
        config['post_adding'] = postAdding2;
        config['button_delete_value'] = '<i class="fa fa-trash"></i>';
        config['button_add_value'] = 'Ajouter un groupe';
        config['collection__content'] = 'collection--content--skillGroups';
        config['collection__add'] = 'collection--add--skillGroups';
        config['add__item__collection'] = 'add--item--collection--skillGroups';
        config['collection__delete'] = 'collection--delete--skillGroups';
        config['delete__item__collection'] = 'delete--item--collection--skillGroups';
        let c = new Collection(collection, config);
        c.display();
        postAdding2();
    });

    let rangeInputs = document.getElementsByClassName('range--input');
    Array.from(rangeInputs).forEach(function(child) {
        new RangeInput(child);
    });


    function evaluatedInputs() {
        let notEvaluatedInputs = document.getElementsByClassName('not--evaluated--input');
        Array.from(notEvaluatedInputs).forEach(function (child) {
            if(child.dataset.instanciate !== true) {
                addEventEvaluatedInput(child);
                notEvaluatedProcess(child);
                child.dataset.instanciate = 'true';
            }
        });
    }

    evaluatedInputs();

    function addEventEvaluatedInput(elt) {
        elt.addEventListener('click', (e) => {
            /*let skillItem = elt.closest('.skill--item');
            let area = skillItem.getElementsByClassName('progression--area')[0];
            if(elt.checked == true) {
                area.style.display = 'none';
            } else {
                area.style.display = 'flex';
            }*/
            notEvaluatedProcess(elt);
        });
    }

    function notEvaluatedProcess(elt) {
        let skillItem = elt.closest('.skill--item');
        let area = skillItem.getElementsByClassName('progression--area')[0];
        if(elt.checked == true) {
            area.style.display = 'none';
        } else {
            area.style.display = 'flex';
        }
    }

});