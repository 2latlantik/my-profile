import FileSend from './FileSend';

class UploadBlock {

    constructor(upload_area) {
        this.upload_area = upload_area;
        this.upload_context = upload_area.parentElement;
        this.setProgressBar();
        this.setButtons();
        this.setMessages();
        this.setInputs();
        this.setImages();
        this.hideAllMessages();
        upload_area.addEventListener('dragover', (e) => { this.dragover(e) });
        upload_area.addEventListener('dragleave', (e) => { this.dragleave(e) });
        upload_area.addEventListener('drop', (e) => { this.drop(e) });
    }

    static isAdvancedUpload() {
        var div = document.createElement('div');
        return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && 'FormData' in window && 'FileReader' in window;
    }

    dragover(e) {
        e.preventDefault();
        e.stopPropagation();
        this.upload_area.classList.add('is-dragover');
    }

    dragleave(e) {
        e.preventDefault();
        e.stopPropagation();
        this.upload_area.classList.remove('is-dragover');
    }

    drop(e) {
        e.preventDefault();
        e.stopPropagation();
        let droppedFiles = e.dataTransfer.files;
        Array.from(droppedFiles).forEach((file) => {
            let send = new FileSend(this, file);
            send.send();
        });
    }

    setProgressBar() {
        let progressBar = this.upload_context.getElementsByClassName('progress-bar');
        if(progressBar.item(0) != null) {
            this.progressBar = progressBar.item(0);
        } else {
            this.progressBar = null;
        }
    }

    setButtons() {
        let button = this.upload_context.getElementsByClassName('circle-green');
        if(button.item(0) != null) {
            this.buttonGreen = button.item(0);
        } else {
            this.buttonGreen = null;
        }
        button = this.upload_context.getElementsByClassName('circle-orange');
        if(button.item(0) != null) {
            this.buttonOrange = button.item(0);
        } else {
            this.buttonOrange = null;
        }
        button = this.upload_context.getElementsByClassName('circle-red');
        if(button.item(0) != null) {
            this.buttonRed = button.item(0);
        } else {
            this.buttonRed = null;
        }
    }

    setMessages() {
        let uploadComplete = this.upload_context.getElementsByClassName('upload-complete');
        if(uploadComplete.item(0) != null) {
            this.uploadComplete = uploadComplete.item(0);
        } else {
            this.uploadComplete = null;
        }
        let uploadError = this.upload_context.getElementsByClassName('upload-error');
        if(uploadError.item(0) != null) {
            this.uploadError = uploadError.item(0);
        } else {
            this.uploadError = null;
        }
    }

    setInputs() {
        this.nameFile = this.upload_context.querySelector('[name*="name"]');
        this.pathFile = this.upload_context.querySelector('[name*="path"]');
    }

    defineInputs(name, path) {
        if(this.nameFile != null) {
            this.nameFile.value = name;
        }

        if(this.pathFile != null) {
            this.pathFile.value = path;
        }
    }

    setImages() {
        let img = this.upload_context.getElementsByTagName('img');
        if(img.item(0) != null) {
            this.imgElement = img.item(0);
        } else {
            this.imgElement = null;
        }
        let svg = this.upload_context.getElementsByTagName('svg');
        if(svg.item(0) != null) {
            this.svgElement = svg.item(0);
        } else {
            this.svgElement = null;
        }
    }

    circleGreenOn() {
        this.switchOn(this.buttonGreen);
    }
    circleOrangeOn() {
        this.switchOn(this.buttonOrange);
    }
    circleRedOn() {
        this.switchOn(this.buttonGreen);
    }

    circleGreenOff() {
        this.switchOff(this.buttonGreen);
    }
    circleOrangeOff() {
        this.switchOff(this.buttonOrange);
    }
    circleRedOff() {
        this.switchOff(this.buttonGreen);
    }

    switchOn(elt) {
        elt.classList.add('circle-lighter');
    }

    switchOff(elt) {
        elt.classList.remove('circle-lighter');
    }

    hideAllMessages() {
        this.hideMessage(this.uploadError);
        this.hideMessage(this.uploadComplete);
    }

    hideMessage(message) {
        if(message != null) {
            message.style.display = 'none';
        }
    }

    showMessageComplete() {
        this.showMessage(this.uploadComplete);
    }

    showMessageError() {
        this.showMessage(this.uploadError);
    }

    showMessage(message) {
        if(message != null) {
            message.style.display = 'block';
        }
    }

    setImage(name, path) {

        if(this.imgElement != null) {
            this.imgElement.src = path;
        }

        if(this.svgElement != null) {
            let imgElement = new Image();
            imgElement.src = path;
            this.upload_area.insertBefore(imgElement, this.svgElement);
            this.svgElement.remove();
        }
    }
}

export default UploadBlock;