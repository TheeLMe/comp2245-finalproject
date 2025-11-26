document.getElementById("loginForm").addEventListener("submit", function(e) {
  e.preventDefault();
  const formData = new FormData(this);

  fetch("login.php", {
    method: "POST",
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      window.location.href = "dashboard.html"; 
    } else {
      document.getElementById("error").textContent = data.message;
    }
  });
});
