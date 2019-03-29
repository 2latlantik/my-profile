
class RichText {
    constructor(area, quill) {
        this.area = area;
        this.quill = quill;
        this.editor = this.firstElementByClassName('ql-editor', area);
        this.inputDelta = this.firstElementByClassName('rich--text--delta', area);
        this.inputHtml = this.firstElementByClassName('rich--text--html', area);
        this.editor.addEventListener('blur', (e) => { this.blurEditor(e) });
        this.setContent();
    }

    firstElementByClassName(className, root) {
        let elt = root.getElementsByClassName(className);
        if(elt.length > 0) {
            return elt[0];
        }
        return '';
    }

    setContent() {
        let delta = JSON.parse(this.inputDelta.value);
        this.quill.setContents(delta, 'api');
    }

    blurEditor(e) {
        let delta = JSON.stringify(this.quill.getContents());
        let html = this.quill.root.innerHTML;
        this.inputDelta.value = delta;
        this.inputHtml.value = html;
    }
}

export default RichText;