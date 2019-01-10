class TagsArea  {
    constructor(area) {
        this.area = area;
        this.values = this.firstElementByClassName('tags--values', area);
        this.input = this.firstElementByClassName('tags--input', area);
        this.list = this.firstElementByClassName('tags--list', area);
        this.setEventsListener();
        this.initializeTagsValues();
    }

    setEventsListener() {
        this.input.addEventListener('keypress', (e) => { this.pressInput(e) });
        this.input.addEventListener('blur', (e) => { this.blurInput(e) });
    }

    initializeTagsValues() {
        let values = this.values.value;
        if(values == '') return ;
        let tab = values.split(',');
        for(let i = 0; i < tab.length ; i++) {
            this.appendToList(tab[i]);
        }
    }

    firstElementByClassName(className, root) {
        let elt = root.getElementsByClassName(className);
        if(elt.length > 0) {
            return elt[0];
        }
        return '';
    }

    firstElementByTagName(tagName, root) {
        let elt = root.getElementsByTagName(tagName);
        if(elt.length > 0) {
            return elt[0];
        }
        return '';
    }

    pressInput(e) {
        let key = e.which | e.keyCode;
        if(key === 13) {
            this.addTag();
            e.preventDefault();
        } else if(key === 44) {
            this.addTag();
            e.preventDefault();
        }
    }

    blurInput(e) {
        this.addTag();
    }

    addTag() {
        let value = this.input.value.trim();

        value = value.replace(',', '');

        if(value == '') {
            this.input.value = '';
            return;
        }

        let isNewTag = this.checkNewTag(value);

        if(isNewTag) {
            this.addInInput(value);
            this.appendToList(value);
        }

        this.input.value = '';
    }

    appendToList(value) {
        let span = document.createElement('span');
        span.classList.add('tag');
        /* First span */
        let content = document.createElement('span');
        content.innerHTML = value;
        span.appendChild(content);
        /* link to delete */
        let link = document.createElement('a');
        link.innerHTML = 'x';
        link.href = '#';
        link.title = 'Removing tag';
        link.addEventListener('click', (e) => { this.deleteTag(e) })
        span.appendChild(link);
        /* add new Element */
        this.list.appendChild(span);
    }

    deleteTag(e) {
        let targ = e.target || e.srcElement;

        let item = targ.closest('.tag');
        if(item !== null) {
            item.parentNode.removeChild(item);
            let tag = this.firstElementByTagName('span', item).innerHTML;
            this.deleteInInput(tag);
        }
        e.preventDefault();
    }

    addInInput(tag) {
        let values = this.values.value;
        values = values + ',' + tag;
        this.values.value = values;
    }

    deleteInInput(tag) {
        let values = new Array();
        let tab = this.values.value.split(',');
        for(let i = 0; i < tab.length ; i++) {
            if(tab[i] != tag) {
                values.push(tab[i]);
            }
        }
        this.values.value = values.join(',');
    }

    checkNewTag(val) {
        let values = this.values.value;
        if(!this.existsTag(values, val)) {
            return true;
        }
        return false;
    }

    existsTag(values, val) {
        let tab = values.split(',');
        for(let i = 0; i < tab.length ; i++) {
            if(tab[i] == val) {
                return true;
            }
        }
        return false;
    }
}

export default TagsArea;






