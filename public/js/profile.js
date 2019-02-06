
$(document).ready(function() {

    let postAdding = function () {
        $('.js-datepicker').datepicker({
            format: "dd/mm/yyyy",
            todayBtn: true,
            language: "fr"
        });

    };

    let postAdding2 = function () {
        let collections = document.getElementsByClassName('collection--skills');
        Array.from(collections).forEach(function(collection) {
            if(collection.dataset.instanciate !== 'true') {
                let config = [];
                config['button_delete_value'] = '<i class="fa fa-trash"></i>';
                config['collection__item'] = 'skill--item';
                let c = new Collection(collection, config);
                c.display();
            }
        });
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


});