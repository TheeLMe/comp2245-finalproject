document.addEventListener("DOMContentLoaded", () => {
  const id = new URLSearchParams(window.location.search).get("id");
  if (!id) return;

  fetch("contact_getDetails.php?id=" + id)
    .then(res => res.json())
    .then(contact => {
      if (contact.error) {
        alert(contact.error);
        return;
      }

      // Inject values into the HTML spans
      document.querySelector(".value-title").textContent = contact.title;
      document.querySelector(".value-name").textContent = contact.firstname + " " + contact.lastname;
      document.querySelector(".value-email").textContent = contact.email;
      document.querySelector(".value-company").textContent = contact.company;
      document.querySelector(".value-telephone").textContent = contact.telephone;
      document.querySelector(".value-assigned").textContent = contact.assigned_first + " " + contact.assigned_last;
      document.querySelector(".value-created").textContent = contact.created_at;
      document.querySelector(".value-updated").textContent = contact.updated_at;

      // Notes section (if you want to load dynamically)
      const notesSection = document.querySelector(".notes-section");
      if (contact.notes && contact.notes.length > 0) {
        notesSection.innerHTML = "<h3 class='section-title'>Notes</h3>";
        contact.notes.forEach(note => {
          const noteDiv = `
            <div class="note">
              <div class="note-meta">
                By ${note.author} — ${note.created_at}
              </div>
              <div>${note.content}</div>
            </div>
          `;
          notesSection.insertAdjacentHTML("beforeend", noteDiv);
        });
      }
    })
    .catch(err => console.error("Error loading contact:", err));
});
