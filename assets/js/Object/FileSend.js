class FileSend {

    constructor(uploadBlock, file) {
        this.uploadBlock = uploadBlock;
        this.file = file;
        this.setFile();
        this.initializeXhr();
        this.statesXhr();
    }

    setFile() {
        this.formData = new FormData();
        this.formData.append('image', this.file, this.file.name);
    }

    initializeXhr() {
        this.xhr = new XMLHttpRequest();
        this.reset();
        this.xhr.upload.onprogress = (e) => {
            this.updateProgress(e);
        }
    }

    updateProgress(e) {
        if (e.lengthComputable) {
            let percent = e.loaded / e.total *100;
            percent = Math.round(percent*100)/100;
            this.uploadBlock.setProgressBarValue(percent);
        }
    }

    statesXhr() {
        this.xhr.onreadystatechange = (e) => {
            if (this.xhr.readyState === XMLHttpRequest.HEADERS_RECEIVED) {
                this.headersReceived();
            }
            if(this.xhr.readyState === XMLHttpRequest.LOADING) {
                this.loading();
            }
            if(this.xhr.readyState === XMLHttpRequest.DONE && this.xhr.status != 0) {
                this.done();
            }
        }
    }

    headersReceived() {
        this.uploadBlock.circleGreenOn();
        this.uploadBlock.hideAllMessages();
    }

    loading() {
        this.uploadBlock.circleOrangeOn();
    }

    done() {
        this.uploadBlock.circleOrangeOff();
        if (this.xhr.status == 200) {
            let object = JSON.parse(this.xhr.responseText);
            if (object.success == false) {
                this.error();
            } else {
                this.uploadBlock.setImage(object.name, object.path);
                this.uploadBlock.defineInputs(object.name, object.path);
                this.uploadBlock.input_upload.value = '';
                this.uploadBlock.showMessageComplete();
            }
        } else {
            this.error();
        }
    }

    error() {
        let object = JSON.parse(this.xhr.responseText);
        this.uploadBlock.circleRedOn();
        this.uploadBlock.circleGreenOff();
        this.uploadBlock.showMessageError(object.message);
    }

    reset() {
        this.uploadBlock.setProgressBarValue(0, true);
        this.uploadBlock.clearMessageError();
    }

    send() {
        this.xhr.open('POST', 'upload', true);
        this.xhr.setRequestHeader('x-file-type', this.file.type);
        this.xhr.setRequestHeader('x-file-size', this.file.size);
        this.xhr.setRequestHeader('x-file-name', this.file.name);
        this.xhr.send(this.formData);
    }
}

export default FileSend;