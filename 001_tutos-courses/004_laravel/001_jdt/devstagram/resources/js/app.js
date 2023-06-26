import Dropzone from "dropzone";

const imageInputHidden = document.querySelector("#image-name");

// // para q no se active basado en 1 css class, sino q le decimos manualmente
Dropzone.autoDiscover = false;

const dropzone = new Dropzone("#dropzone", {
    // dictDefaultMessage: "Sube aquí tu imagen",
    acceptedFiles: ".png,.jpg,.jpeg,.gif",
    addRemoveLinks: true,
    maxFiles: 1,
    uploadMultiple: false,

    // it's executed whent it has been started
    init: function () {
        if (imageInputHidden.value.trim()) {
            const uploadedImage = {};
            uploadedImage.size = 1234;
            uploadedImage.name = imageInputHidden.value;

            this.options.addedfile.call(this, uploadedImage);
            this.options.thumbnail.call(
                this,
                uploadedImage,
                `/uploads/${uploadedImage.name}`
            );

            uploadedImage.previewElement.classList.add(
                "dz-success",
                "dz-complete"
            );
        }
    },
});

dropzone.on("success", (file, response) => {
    imageInputHidden.value = response.image;
});

dropzone.on("removedfile", () => {
    imageInputHidden.value = "";
});
