document.addEventListener("DOMContentLoaded", () => {
  const userListDiv = document.getElementById("userList");

  let url = `user.php?action=list`;

  fetch(url)
    .then(response => response.text())
    .then(data => {
      userListDiv.innerHTML = data; 
    })
    .catch(error => {
      userListDiv.innerHTML = `<p style="color:red;">Error: ${error.message}</p>`;
    });
});