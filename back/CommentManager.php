<?php

class CommentManager
{
	private string $filePath;

	public function __construct(string $filePath)
	{
		$this->filePath = $filePath;
	}

	// Handles the POST /comment route
	public function handleCommentRequest(): void
	{
		// Ensure the correct Content-Type header
		if ($_SERVER['CONTENT_TYPE'] !== 'application/x-www-form-urlencoded') {
			http_response_code(400);
			echo json_encode(['error' => 'Invalid Content-Type header']);
			return;
		}

		// Validate and sanitize form data
		$firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		if (!$firstname || !$lastname || !$message) {
			http_response_code(400);
			echo json_encode(['error' => 'Missing required fields']);
			return;
		}

		// Create a new comment
		$newComment = [
			'firstname' => $firstname,
			'lastname' => $lastname,
			'message' => $message,
			'timestamp' => date('c'),
		];

		// Save the comment
		$this->saveComment($newComment);

		// Return the updated list of comments
		http_response_code(200);
		header('Content-Type: application/json');
		echo json_encode($this->getAllComments());
	}

	// Saves a new comment to the file
	private function saveComment(array $comment): void
	{
		$comments = $this->getAllComments();
		$comments[] = $comment;

		file_put_contents($this->filePath, json_encode($comments, JSON_PRETTY_PRINT));
	}

	// Retrieves all comments from the file
	private function getAllComments(): array
	{
		if (!file_exists($this->filePath)) {
			return [];
		}

		$content = file_get_contents($this->filePath);
		return json_decode($content, true) ?? [];
	}

	public function handleGetCommentsRequest(): void
	{
		http_response_code(200);
		header('Content-Type: application/json');
		echo json_encode($this->getAllComments());
	}
}
