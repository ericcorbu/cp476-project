window.onload = () => {
  fetchMyPhotos();
};

const updateDescriptions = (photoId, newDescription, isPrivate) => {
  const json = {
    message: "update",
    id: photoId,
    description: newDescription,
    is_private: isPrivate,
  };

  const req = new XMLHttpRequest();
  req.onreadystatechange = function () {
    if (this.readyState != 4) return;

    if (this.status == 200) {
      alert("Description/Details updated successfully");
      location.reload();
      //console.log(this.response);
    }
  };
  req.open("POST", "", false);
  req.send(JSON.stringify(json));
};
const deletePhotos = (photoId) => {
  const json = { message: "delete", id: photoId };
  const req = new XMLHttpRequest();
  req.onreadystatechange = function () {
    if (this.readyState != 4) return;
    if (this.status == 200) {
      alert("Photo deleted successfully");
      location.reload();
    }
  };
  req.open("POST", "", false);
  req.send(JSON.stringify(json));
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

    const photoDescription = document.createElement("textarea");
    photoDescription.className = "descriptionBox";
    photoDescription.innerHTML = photo.description;

    const updateButton = document.createElement("button");
    updateButton.className = "button";
    updateButton.innerHTML = "Update";
    updateButton.onclick = () =>
      updateDescriptions(
        photo.imageId,
        photoDescription.value,
        privateRadioButton.checked
      );

    const deleteButton = document.createElement("button");
    deleteButton.className = "deleteButton button";
    deleteButton.innerHTML = "❌";
    deleteButton.onclick = () => deletePhotos(photo.imageId);

    const visibilityForm = document.createElement("form");

    const publicRadioButton = document.createElement("input");
    publicRadioButton.type = "radio";
    publicRadioButton.name = "visibility";
    publicRadioButton.value = "public";
    const publicLabel = document.createElement("label");
    publicLabel.textContent = "Public";

    const privateRadioButton = document.createElement("input");
    privateRadioButton.type = "radio";
    privateRadioButton.name = "visibility";
    privateRadioButton.value = "private";
    const privateLabel = document.createElement("label");
    privateLabel.textContent = "Private";

    visibilityForm.appendChild(photoDescription);
    visibilityForm.appendChild(publicRadioButton);
    visibilityForm.appendChild(publicLabel);
    visibilityForm.appendChild(privateRadioButton);
    visibilityForm.appendChild(privateLabel);
    visibilityForm.appendChild(updateButton);

    if (photo.is_private) {
      privateRadioButton.checked = true;
    } else {
      publicRadioButton.checked = true;
    }

    photoContainer.appendChild(userHeader);
    userHeader.appendChild(deleteButton);
    photoContainer.appendChild(imageElement);

    photoContainer.appendChild(visibilityForm);

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
      showMyPhotos(JSON.parse(this.response).reverse() || [{ description: "nophoto" }]);
      // we get the returned data
    }

    // end of state change: it can be after some time (async)
  };
  req.open("POST", "", false);
  req.send();
};
