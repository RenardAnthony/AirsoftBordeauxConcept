const uploadedImageDiv = document.getElementById("uploadedImage");
const fileUpload = document.getElementById("avatar");
fileUpload.addEventListener("change", getImage, false);
let cropper = null;
let myGreatImage = null;
const croppedImage = document.getElementById("croppedImage");

function getImage() {
    console.log("image", this.files[0]);
    const imageToProcess = this.files[0];

    let newImg = new Image();
    newImg.src = URL.createObjectURL(imageToProcess);
    newImg.id = "myGreatImage";
    uploadedImageDiv.innerHTML = ""; // Clear previous uploaded image
    uploadedImageDiv.appendChild(newImg);

    processImage();
}

function processImage() {
    myGreatImage = document.getElementById("myGreatImage");

    cropper = new Cropper(myGreatImage, {
        aspectRatio: 1,
        crop(event) {
            console.log(event);
            const canvas = cropper.getCroppedCanvas();
            croppedImage.src = canvas.toDataURL("image/jpeg", 0.5); // Réduire la qualité à 50%
            cropImage(); // Appeler automatiquement la fonction de recadrage
        },
    });
}



function cropImage() {
    const imgUrl = cropper.getCroppedCanvas().toDataURL();
    const img = document.createElement("img");
    img.src = imgUrl;
    document.getElementById("cropResult").innerHTML = ""; // Clear previous cropped image
    document.getElementById("cropResult").appendChild(img);
}

function cropImageAndUpload() {
    const croppedCanvas = cropper.getCroppedCanvas({
        width: 500,
        height: 500,
    });

    croppedCanvas.toBlob(function (blob) {
        const formData = new FormData();
        formData.append('avatar', blob, 'cropped.jpg');

        fetch('../php/uploadCroppedImage.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            // Gérer la réponse du serveur ici
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }, 'image/jpeg'); // Vous pouvez ajuster le format ici (jpeg, png, etc.)
}

