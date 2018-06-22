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
        this.formData.append('image', this.file, this.file.name)
    }

    initializeXhr() {
        this.xhr = new XMLHttpRequest();
        this.xhr.open('POST', 'upload', true);
        this.xhr.setRequestHeader('x-file-type', this.file.type);
        this.xhr.setRequestHeader('x-file-size', this.file.size);
        this.xhr.setRequestHeader('x-file-name', this.file.fileName);
    }

    statesXhr() {
        this.xhr.onreadystatechange = () => {
            if (this.xhr.readyState == XMLHttpRequest.HEADERS_RECEIVED) {
                this.headersReceived();
            }
            if(this.xhr.readyState == XMLHttpRequest.LOADING) {
                this.loading();
            }
            if(this.xhr.readyState == XMLHttpRequest.DONE) {
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
            this.uploadBlock.setImage(object.name, object.path);
            this.uploadBlock.defineInputs(object.name, object.path);
            this.uploadBlock.showMessageComplete();
        } else {
            this.uploadBlock.circleRedOn();
            this.uploadBlock.circleGreenOff();
            this.uploadBlock.showMessageError();
        }
    }

    send() {
        this.xhr.send(this.formData);
    }
}

export default FileSend;