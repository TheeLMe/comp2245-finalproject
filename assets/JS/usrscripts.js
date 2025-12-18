document.addEventListener("DOMContentLoaded", () => {
  const userListDiv = document.getElementById("userList");
  const addbtn = document.getElementById("addbtn");

  let url = `user.php?action=list`;
  let url1 = 'addbtnhide.php?action=list';

  fetch(url1)
    .then(response => response.text())
    .then(data => {
      addbtn.innerHTML = data;
    })
    .catch(error => {
      addbtn.innerHTML = `<p style="color:red;">Error: ${error.message}</p>`;
    });

  fetch(url)
    .then(response => response.text())
    .then(data => {
      userListDiv.innerHTML = data; 
    })
    .catch(error => {
      userListDiv.innerHTML = `<p style="color:red;">Error: ${error.message}</p>`;
    });
});