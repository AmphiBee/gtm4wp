document.addEventListener('DOMContentLoaded', function() {
	const projectIDInput = document.getElementById('gtm4wp-options[integrate-axeptio-projectID]');
	const validateButton = document.getElementById('axeptio-project-validate-button');
	const errorMessageSpan = document.querySelector('.axeptio_project_validation_error');
	const projectsList = document.getElementById('gtm4wp-options[integrate-axeptio-version]');
	const projectVersion = document.querySelector('.axeptio-project-version');

	async function validateAccountID() {
		errorMessageSpan.style.display = 'none';
		projectVersion.style.display = 'none';
		errorMessageSpan.textContent = '';

		const accountID = projectIDInput.value.trim();

		if (accountID === '') {
			errorMessageSpan.textContent = gtm4wpAxeptio.empty_account_id;
			errorMessageSpan.style.display = 'block';
			return;
		}

		try {
			const timestamp = new Date().getTime();
			const url = `https://client.axept.io/${accountID}.json?nocache=${timestamp}`;
			const response = await fetch(url);
			if (!response.ok) {
				throw new Error('Network response was not ok');
			}
			const data = await response.json();

			if (data.cookies && data.cookies.length > 0) {
				const existingCookieNames = new Set();
				const options = data.cookies.filter(cookie => {
					if (!existingCookieNames.has(cookie.name)) {
						existingCookieNames.add(cookie.name);
						return true;
					}
					return false;
				}).map(cookie => ({
					value: cookie.name,
					text: cookie.title
				}));

				// Clear previous options
				projectsList.innerHTML = '';

				// Add new options
				options.forEach(option => {
					const opt = document.createElement('option');
					opt.value = option.value;
					opt.textContent = option.text;
					projectsList.appendChild(opt);
				});

				// Set the saved value if exists
				const savedValue = projectsList.getAttribute('data-axeptio-project-version');
				if (savedValue) {
					projectsList.value = savedValue;
				}

				projectVersion.style.display = 'block';
			} else {
				errorMessageSpan.textContent = gtm4wpAxeptio.non_existing_account_id;
				errorMessageSpan.style.display = 'block';
			}
		} catch (error) {
			errorMessageSpan.textContent = gtm4wpAxeptio.verification_error;
			errorMessageSpan.style.display = 'block';
		}
	}

	validateButton.addEventListener('click', function(event) {
		event.preventDefault(); // Empêche l'envoi du formulaire
		validateAccountID();
	});

	// Validate and display projects list if projectIDInput is not empty on page load
	if (projectIDInput.value.trim() !== '') {
		validateAccountID();
	}
});
