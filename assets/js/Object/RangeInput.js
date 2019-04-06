
class RangeInput {
    constructor(range) {
        this.range = range;
        this.findInput();
        this.range.addEventListener('change', (e) => { this.changeRange(e) });
        this.input.addEventListener('keyup', (e) => { this.changeInput(e) });
        this.initiateValues();
        this.range.dataset.instanciate = true;
    }

    firstElementByClassName(className, root) {
        let elt = root.getElementsByClassName(className);
        if(elt.length > 0) {
            return elt[0];
        }
        return '';
    }

    findInput() {
        let parent = this.range.closest('.row');
        let inputValue = this.firstElementByClassName('range--value', parent);
        this.input = inputValue;
    }

    changeRange(e) {
        this.input.value = this.range.value
    }

    changeInput(e) {
        this.range.value = this.input.value
    }

    initiateValues() {
        if(this.input.value === '') {
            this.range.value = 0;
            this.input.value = 0;
        }
    }
}

export default RangeInput;