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
    // Vérifier le type de contenu de la requête
    if ($_SERVER['CONTENT_TYPE'] !== 'application/x-www-form-urlencoded') {
        http_response_code(400);
        echo json_encode(["error" => "Bad Request: Invalid content type"]);
        return;
    }

    // Récupérer et valider les données
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $message = htmlspecialchars($_POST['message']);

    if (!$firstname || !$lastname || !$message) {
        http_response_code(400);
        echo json_encode(["error" => "Bad Request: Missing or invalid fields"]);
        return;
    }

    // Créer un objet commentaire
    $comment = [
        'firstname' => $firstname,
        'lastname' => $lastname,
        'message' => $message,
        'date' => date('Y-m-d H:i:s')
    ];

    // Sauvegarder le commentaire
    $this->saveComment($comment);

    // Retourner une réponse avec tous les commentaires
    http_response_code(200);
	header('Content-Type: application/json; charset=utf-8');
    echo json_encode($this->getAllComments(), JSON_PRETTY_PRINT);
}


	// Saves a new comment to the file
	private function saveComment(array $comment): void
	{
		$comments = $this->getAllComments();
		$comments[] = $comment;

		file_put_contents($this->filePath, json_encode($comments, JSON_PRETTY_PRINT));
	}

	// Retrieves all comments from the file
	private function getAllComments(): array {}

	public function handleGetCommentsRequest(): void {
	}
	
}
