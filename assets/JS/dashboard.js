function loadContacts(filter = "all") {
  fetch("get_contacts.php?filter=" + filter) // ✅ corrected path
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById("contacts-body");
      tbody.innerHTML = ""; // clear old rows

      if (!Array.isArray(data) || data.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5">No contacts found.</td></tr>`;
        return;
      }

      data.forEach(c => {
        const row = `
          <tr>
            <td>${c.title} ${c.firstname} ${c.lastname}</td>
            <td>${c.email}</td>
            <td>${c.company}</td>
            <td>${c.type ? c.type.toUpperCase() : ""}</td>
            <td><a href="contact.php?id=${c.id}">View</a></td>
          </tr>
        `;
        tbody.insertAdjacentHTML("beforeend", row);
      });
    })
    .catch(err => {
      console.error("Error loading contacts:", err);
      const tbody = document.getElementById("contacts-body");
      tbody.innerHTML = `<tr><td colspan="5">Error loading contacts.</td></tr>`;
    });
}

// Attach filter link events
document.querySelectorAll(".filters a").forEach(link => {
  link.addEventListener("click", e => {
    e.preventDefault();
    const filter = link.dataset.filter;
    loadContacts(filter);
  });
});

// Load all contacts on page load
document.addEventListener("DOMContentLoaded", () => {
  loadContacts("all");
});
