// Description: This file contains the JavaScript code for the front-end of the application.

const form = document.getElementById("post-comment");
// Trigger the getComments function when the form is submitted
form.addEventListener("submit", async (event, form) => {
	await sendComment(event, form);
});

const button = document.getElementById("get-comments");
// Trigger the getComments function when the button is clicked
button.addEventListener("click", async () => {
	await getComments();
});

/**
 * This function sends a POST request to the server with the form data to add a new comment.
 * @param {*} event The event that triggered the function
 * @param {*} form The form data to be sent to the server
 */
async function sendComment(event, form) {
	// Prevent the default form submission (page reload)
	event.preventDefault();

	try {
		// Send a POST request to the server with the form data
		const response = await fetch("http://localhost:8080/comment", {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded",
			},
			// Serialize the form data to URL-encoded format
			body: new URLSearchParams(new FormData(form)),
		});

		if (response.ok) {
			// If the request was successful, log the result
			const result = await response.json();
			console.log("Form submitted successfully:", result);
		} else {
			console.error("Form submission failed:", response.status, response.statusText);
		}
	} catch (error) {
		console.error("Error occurred:", error);
	}
}

/**
 * This function sends a GET request to the server to retrieve all comments.
 */
async function getComments() {
	try {
		// Send a GET request to the server to retrieve all comments
		const response = await fetch("http://localhost:8080/comment", {
			method: "GET",
		});

		console.log(response);

		if (response.ok) {
			const result = await response.json();
			console.log("Comments retrieved successfully:", result);
		} else {
			console.error("Comments retrieval failed:", response.status, response.statusText);
		}
	} catch (error) {
		console.error("Error occurred:", error);
	}
}