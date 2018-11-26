
class Collection {
    constructor(collection, post_adding) {
        this.collection = collection;
        this.postAdding = post_adding;
        this.contentArea = this.getContentArea();
        this.addingArea = this.getAddingArea();
        this.initializeProperties();
        this.setPrototype();
        this.setIndex();
    }

    /**
     *      Méthode intra-constructor
     *
     */
    getContentArea() {
        let content = this.collection.getElementsByClassName('collection--content');
        if(content.length === 0) {
            return this.collection;
        } else {
            return content[0];
        }
    }

    getAddingArea() {
        let content = this.collection.getElementsByClassName('collection--add');
        if(content.length === 0) {
            return this.collection;
        } else {
            return content[0];
        }
    }

    getDeletingArea(item) {
        let content = item.getElementsByClassName('collection--delete');
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
        if(this.allowAdd !== 1) {
            return;
        }

        this.addingArea.insertAdjacentHTML('beforeend', this.buttonAdd);
        let button = this.addingArea.getElementsByClassName('add--item--collection')[0];
        button.innerHTML = this.buttonAddValue;
        button.addEventListener('click', (e) => {this.addItemToCollection(e)});
    }

    addDeleteButton(item) {
        if(this.allowDelete !== 1) {
            return;
        }
        let deletingArea = this.getDeletingArea(item);
        deletingArea.insertAdjacentHTML('beforeend', this.buttonDelete);
        let button = deletingArea.getElementsByClassName('delete--item--collection')[0];
        button.innerHTML = this.buttonDeleteValue;
        button.addEventListener('click', (e) => {this.deleteItemFromCollection(e)});
    }

    setIndex() {
        this.index = 0;
    }

    /**
     *  Add Item To Collection Really
     * @param e
     */
    addItemToCollection(e) {
        this.index = this.index + 1;

        let prototype = this.prototype.replace(/__name__/g, this.index);

        this.contentArea.insertAdjacentHTML('beforeend', prototype);

        let item = this.contentArea.querySelectorAll(".collection--item:last-child");
        if(item.length === 0) {
            item = null;
        } else {
            item = item[0];
        }
        this.addDeleteButton(item);

        this.postAdding();

        this.setItemsNumber();
    }


    /**
     *  Delete Item From Collection Really
     * @param e
     */
    deleteItemFromCollection(e) {
        let targ = e.target || e.srcElement;

        let item = targ.closest('.collection--item');

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
        let items = this.contentArea.querySelectorAll(".collection--item");
        Array.from(items).forEach(function(item) {
            let content = item.querySelector('.item--number');
            if(content !== undefined) {
                k = k + 1;
                content.innerHTML = k;
            }
        });
    }

    setDeleteButtons() {
        let items = this.contentArea.querySelectorAll(".collection--item");
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
            'button_add' : '<button type="button" class="btn btn-primary add--item--collection" ></button>',
            'button_add_value': 'Add',
            'allow_add' : 1,
            'button_delete': '<button type="button" class="btn btn-danger delete--item--collection"></button>',
            'button_delete_value': 'Delete',
            'allow_delete' : 1,
            'allow_item_number': 1
        };
    }
}

export default Collection;