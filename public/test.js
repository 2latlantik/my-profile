class DragAndDropUpload {

    static isPossible() {
        var div = document.createElement('div');
        return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && 'FormData' in window && 'FileReader' in window;
    }

}





var elements = document.getElementsByClassName('upload_area');

Array.from(elements).forEach(function(child) {
    let a = new UploadBlock(child);
   /* console.log(a);
    child.addEventListener('dragover', function (e) {
        e.preventDefault();
        e.stopPropagation();
        child.classList.add('is-dragover');
    });
    child.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        child.classList.remove('is-dragover');
    });
    child.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        droppedFiles = e.dataTransfer.files;

        var formData = new FormData();

        Array.from(droppedFiles).forEach(function(elt) {             
            formData.append('image', elt, elt.name)
            file = elt;
        });

        

        let progressBar = child.parentElement.getElementsByClassName('progress-bar');


        let buttonGreen = child.parentElement.getElementsByClassName('circle-green');
        let buttonOrange = child.parentElement.getElementsByClassName('circle-orange');
        let buttonRed = child.parentElement.getElementsByClassName('circle-red');

        let nameFile = child.parentElement.querySelector('[name*="name"]');
        let pathFile = child.parentElement.querySelector('[name*="path"]');
        let imgElement = child.parentElement.getElementsByTagName('img');
        let svgElement = child.parentElement.getElementsByTagName('svg');

        let messageUploadComplete = child.parentElement.getElementsByClassName('upload-complete');
        let messageUploadError = child.parentElement.getElementsByClassName('upload-error');

        let xhr = new XMLHttpRequest();
        
        
        console.log(child);
        xhr.upload.onprogress = function(e) {
            if(e.lengthComputable) {
                var percentComplete = (e.loaded / e.total) * 100;
                progressBar.item(0).style.width = percentComplete + '%';
            }
        }

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.HEADERS_RECEIVED) {
                buttonGreen.item(0).classList.add('circle-lighter');
                messageUploadComplete.item(0).style.display = 'none';
                messageUploadError.item(0).style.display = 'none';
            }
            if (xhr.readyState === XMLHttpRequest.LOADING) {
                buttonOrange.item(0).classList.add('circle-lighter');
            }
            if (xhr.readyState === XMLHttpRequest.DONE) {
                buttonOrange.item(0).classList.remove('circle-lighter');
                if (xhr.status === 200) {
                    // Here the callback gets implemented
                    
                    object = JSON.parse(xhr.responseText);
                    nameFile.value = object.name;
                    pathFile.value = object.path;

                    if(imgElement.item(0) != null) {
                        imgElement.item(0).src = object.path;
                    }
                    if(svgElement.item(0) != null) {
                        imgElement = new Image();
                        imgElement.src = object.path;

                        child.insertBefore(imgElement, svgElement.item(0));
                        svgElement.item(0).remove();
                    }

                    messageUploadComplete.item(0).style.display = 'block';
                    messageUploadError.item(0).style.display = 'block';
                    console.log(object);
                } else {
                    buttonRed.item(0).classList.add('circle-lighter');
                    buttonGreen.item(0).classList.remove('circle-lighter');
                }
            }
        };


        $authorizedTypeMime = [
            'image/jpeg',
            'image/png'
        ];

        if(inArray(file.type, $authorizedTypeMime) == false) {
            console.log('bad type mime');
            return ;
        }

        if(file.size > 2097152 ) {
            console.log('excessive size');
            return;
        }

        xhr.open('POST', 'upload', true);
        // Faire les headers
        console.log(file);
        //xhr.setRequestHeader('Content-Type', 'multipart/form-data');
        xhr.setRequestHeader('x-file-type', file.type);
        xhr.setRequestHeader('x-file-size', file.size);
        xhr.setRequestHeader('x-file-name', file.fileName);
        xhr.send(formData);
    });
*/

    function inArray(needle, haystack) {
        var length = haystack.length;
        for(var i = 0; i < length; i++) {
            if(haystack[i] == needle) return true;
        }
        return false;
    }
})
