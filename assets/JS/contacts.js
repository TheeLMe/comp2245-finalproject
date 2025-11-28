document.addEventListener("DOMContentLoaded", () => {
    const titleElement = document.getElementById("title");
    const assign = document.getElementById('assign');
    const saveBtn = document.getElementById('SaveBtn');
    const firstname = document.getElementById('firstname');
    const lastname = document.getElementById('lastname');
    const email = document.getElementById('email');
    const phone = document.getElementById('phone');
    const telephone = document.getElementById('telephone');
    const company = document.getElementById('comp');
    const jobtitle = document.getElementById('roletype');

    saveBtn.addEventListener('click', () => {
        const data = {
            firstname: firstname.value,
            lastname: lastname.value,
            email: email.value,
            phone: phone.value,
            telephone: telephone.value,
            company: company.value,
            jobtitle: jobtitle.value,
            assign: assign.value
        };

        fetch('add_contacts.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams(data)
        })
        .then(response => response.text())
        .then(data => alert(data))
        .catch(error => console.error('Error:', error));

    });
});