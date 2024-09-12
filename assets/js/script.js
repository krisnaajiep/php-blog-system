const image = document.querySelectorAll("#image");
for (let index = 0; index < image.length; index++) {
  const element = image[index];
  element.addEventListener("change", function () {
    const imgPreview = document.querySelectorAll(".img-preview");

    const oFReader = new FileReader();
    oFReader.readAsDataURL(this.files[0]);

    oFReader.onload = function (oFREvent) {
      imgPreview[index].src = oFREvent.target.result;
    };
  });
}
