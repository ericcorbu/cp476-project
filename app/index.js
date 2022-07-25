window.onload = () => {
  fetchMyPhotos();
};

const showMyPhotos = (photoJson) => {
  const contentDiv = document.querySelector(".content");
  if (photoJson.length === 0) {
    const photoContainer = document.createElement("div");
    photoContainer.className = "photo-container";

    const userHeader = document.createElement("h4");
    userHeader.className = "photo-user-header";
    userHeader.innerHTML = "No photos available";

    const photoDescription = document.createElement("p");
    photoDescription.className = "photo-description";
    photoDescription.innerHTML = "Go to 'Upload Photo' to begin.";

    photoContainer.appendChild(userHeader);
    photoContainer.appendChild(photoDescription);

    contentDiv.appendChild(photoContainer);
  }

  photoJson.forEach((photo) => {
    const photoContainer = document.createElement("div");
    photoContainer.className = "photo-container";

    const userHeader = document.createElement("h4");
    userHeader.className = "photo-user-header";
    userHeader.innerHTML = "@" + photo.displayname;

    const imageElement = document.createElement("img");
    imageElement.src = "./uploads/" + photo.imageId;

    const photoDescription = document.createElement("p");
    photoDescription.className = "photo-description";
    photoDescription.innerHTML = photo.description;

    photoContainer.appendChild(userHeader);
    photoContainer.appendChild(imageElement);
    photoContainer.appendChild(photoDescription);

    contentDiv.appendChild(photoContainer);
  });
};

const fetchMyPhotos = () => {
  const req = new XMLHttpRequest();
  req.onreadystatechange = function () {
    if (this.readyState != 4) return;

    if (this.status == 200) {
      // var data = JSON.parse(this.responseText);
      console.log(this.response);
      //console.log(JSON.parse(this.response));
      showMyPhotos(JSON.parse(this.response) || [{ description: "nophoto" }]);
      // we get the returned data
    }

    // end of state change: it can be after some time (async)
  };
  req.open("POST", "", false);
  req.send();
};
