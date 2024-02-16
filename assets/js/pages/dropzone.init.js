function dropFile() {
    $('.dropzone').each(function () {
        let dropzoneControl = $(this)[0].dropzone;
        if (dropzoneControl) {
            dropzoneControl.destroy();
        }
        $(".dropzone").dropzone({
            autoProcessQueue: true,
            uploadMultiple: false,
            addRemoveLinks: false,
            parallelUploads: 1,
            maxFiles: 1,
            maxFilesize: 2,
            maxThumbnailFilesize: 1,
            acceptedFiles: "image/png,image/jpg,image/jpeg",
            accept: function(file) {
                let fileReader = new FileReader();
                fileReader.readAsDataURL(file);
                fileReader.onloadend = function() { file.previewElement.classList.add("dz-success"); }
                file.previewElement.classList.add("dz-complete");
            },
        });
    });
}