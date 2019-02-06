
class Collection {
    constructor(collection, config) {
        this.collection = collection;
        if ('post_adding' in config) {
            this.postAdding = config['post_adding'];
        }
        this.initializeProperties();
        this.setProperties(config);
        this.contentArea = this.getContentArea();
        this.addingArea = this.getAddingArea();
        this.setPrototype();
        this.setIndex(0);
        this.setItemsNumber();
        this.collection.dataset.instanciate = 'true';
    }

    /**
     *      Méthode intra-constructor
     *
     */
    getContentArea() {
        let content = this.collection.getElementsByClassName(this.collection__content);
        if(content.length === 0) {
            return this.collection;
        } else {
            return content[0];
        }
    }

    getAddingArea() {
        let content = this.collection.getElementsByClassName(this.collection__add);
        if(content.length === 0) {
            return this.collection;
        } else {
            return content[0];
        }
    }

    getDeletingArea(item) {
        let content = item.getElementsByClassName(this.collection__delete);
        if(content.length === 0) {
            return null;
        } else {
            return content[0];
        }
    }

    initializeProperties() {
        let properties = Collection.defaultProperties();
        this.buttonAdd = properties.button_add;
        this.buttonAddValue = properties.button_add_value;
        this.allowAdd = properties.allow_add;
        this.buttonDelete = properties.button_delete;
        this.buttonDeleteValue = properties.button_delete_value;
        this.allowDelete = properties.allow_delete;
        this.allowItemNumber = properties.allow_item_number;
        this.collection__content = properties.collection__content;
        this.collection__item = properties.collection__item;
        this.collection__add = properties.collection__add;
        this.add__item__collection = properties.add__item__collection;
        this.collection__delete = properties.collection__delete;
        this.delete__item__collection = properties.delete__item__collection;
    }

    setProperties(config) {
        if('button_add' in config) {
            this.buttonAdd = config['button_add'];
        }
        if('button_add_value' in config) {
            this.buttonAddValue = config['button_add_value'];
        }
        if('allow_add' in config) {
            this.allowAdd = config['allow_add'];
        }
        if('button_delete' in config) {
            this.buttonDelete = config['button_delete'];
        }
        if('button_delete_value' in config) {
            this.buttonDeleteValue = config['button_delete_value'];
        }
        if('allow_delete' in config) {
            this.allowDelete = config['allow_delete'];
        }
        if('allow_item_number' in config) {
            this.allowItemNumber = config['allow_item_number'];
        }
        if('collection__content' in config) {
            this.collection__content = config['collection__content'];
        }
        if('collection__item' in config) {
            this.collection__item = config['collection__item'];
        }
        if('collection__add' in config) {
            this.collection__add = config['collection__add'];
        }
        if('add__item__collection' in config) {
            this.add__item__collection = config['add__item__collection'];
        }
        if('collection__delete' in config) {
            this.collection__delete = config['collection__delete'];
        }
    }

    /**
     *  First Display to collection
     */
    display() {
        this.addAddingButton();
        this.setDeleteButtons();
    }

    setPrototype() {
        let prototype = this.collection.dataset.prototype;
        this.prototype = prototype;
    }

    /**
     *   Adding add and delete button
     */
    addAddingButton() {
        if (this.allowAdd !== 1) {
            return;
        }
        if (this.addingArea.getElementsByClassName(this.add__item__collection).length == 0) {
            this.addingArea.insertAdjacentHTML('beforeend', this.buttonAdd);
        }
        let buttonAdd = this.addingArea.getElementsByTagName('button')[this.addingArea.getElementsByTagName("button").length - 1];
        buttonAdd.classList.add(this.add__item__collection);
        let button = this.addingArea.getElementsByClassName(this.add__item__collection)[0];
        button.innerHTML = this.buttonAddValue;
        button.addEventListener('click', (e) => {this.addItemToCollection(e)});
    }

    addDeleteButton(item) {
        let deletingArea = this.getDeletingArea(item);
        if(this.allowDelete !== 1 || deletingArea.getElementsByClassName(this.delete__item__collection).length != 0) {
            return;
        }

        deletingArea.insertAdjacentHTML('beforeend', this.buttonDelete);
        let buttonDelete = deletingArea.getElementsByTagName('button')[deletingArea.getElementsByTagName("button").length - 1];
        buttonDelete.classList.add(this.delete__item__collection);
        let button = deletingArea.getElementsByClassName(this.delete__item__collection)[0];
        button.innerHTML = this.buttonDeleteValue;
        button.addEventListener('click', (e) => {this.deleteItemFromCollection(e)});
    }

    setIndex(index) {
        if(this.collection.dataset.index === undefined) {
            index = this.collection.getElementsByClassName(this.collection__item).length;
            this.collection.dataset.index = index;
        } else {
            this.collection.dataset.index = index;
        }
        this.index = index;
    }

    getIndex() {
        return this.collection.dataset.index;
    }

    /**
     *  Add Item To Collection Really
     * @param e
     */
    addItemToCollection(e) {
        this.index = parseInt(this.getIndex());

        //this.index = this.index + 1;
        let prototype = '';
        if(this.collection.dataset.prototype_name === undefined) {
            prototype = this.prototype.replace(/__name__/g, this.index);
        } else {
            let prototype_name = this.collection.dataset.prototype_name;
            let re = new RegExp(prototype_name,"g");
            prototype = this.prototype.replace(re, this.index);
        }

        this.contentArea.insertAdjacentHTML('beforeend', prototype);

        let item = this.contentArea.querySelectorAll("."+this.collection__item+":last-child");

        if(item.length === 0) {
            item = null;
        } else {
            item = item[0];
        }
        this.addDeleteButton(item);

        if(typeof this.postAdding === 'function') {
            this.postAdding();
        }

        this.setItemsNumber();

        this.setIndex(this.index + 1);
    }


    /**
     *  Delete Item From Collection Really
     * @param e
     */
    deleteItemFromCollection(e) {
        let targ = e.target || e.srcElement;

        let item = targ.closest('.' + this.collection__item);

        if(item !== null) {
            item.parentNode.removeChild(item);
        }
        this.setItemsNumber();
    }

    /**
     *  Adjust numerotation
     */
    setItemsNumber() {
        if(this.allowItemNumber !== 1) {
            return;
        }
        let k = 0;
        let items = this.contentArea.querySelectorAll("." + this.collection__item);
        Array.from(items).forEach(function(item) {
            let content = item.querySelector('.item--number');
            if(content !== undefined && content !== null) {
                k = k + 1;
                content.innerHTML = k;
            }
        });
    }

    setDeleteButtons() {
        let items = this.contentArea.querySelectorAll("." + this.collection__item);
        Array.from(items).forEach((item) => {
            this.addDeleteButton(item);
        });
    }

    /**
     * Static Method how return default values
     * @returns {{button_add: string, button_add_value: string, allow_add: number, button_delete: string, button_delete_value: string, allow_delete: number}}
     */

    static defaultProperties() {
        return {
            'button_add' : '<button type="button" class="btn btn-primary" ></button>',
            'button_add_value': 'Add',
            'allow_add' : 1,
            'button_delete': '<button type="button" class="btn btn-danger"></button>',
            'button_delete_value': 'Delete',
            'allow_delete' : 1,
            'allow_item_number': 1,
            'collection__content': 'collection--content',
            'collection__item': 'collection--item',
            'collection__add': 'collection--add',
            'add__item__collection': 'add--item--collection',
            'collection__delete': 'collection--delete',
            'delete__item__collection': 'delete--item--collection'
        };
    }
}

export default Collection;