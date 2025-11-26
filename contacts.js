document.addEventListener('DOMContentLoaded', function() {
    const assign = document.getElementById('assign');
    const saveBtn = document.getElementById('SaveBtn');
    const firstname = document.getElementById('firstname');
    const lastname = document.getElementById('lastname');
    const email = document.getElementById('email');
    const phone = document.getElementById('phone');
    const company = document.getElementById('company');
    const jobtitle = document.getElementById('jobtitle');

    saveBtn.addEventListener('click', function(event) {
        event.preventDefault();
    })

    let url = 'add_contacts.php';

    fetch(url)
        .then(response => response.text())
        .then(data => {
            assign.innerHTML += data; 
        })
        .catch(error => {
            assign.innerHTML = `<option disabled>Error loading users</option>`;
        });

});