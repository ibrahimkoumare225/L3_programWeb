<?php

require_once 'Router.php';
require_once 'CommentManager.php';

// Initialize the router and comment manager
$router = new Router();
$commentManager = new CommentManager(__DIR__ . '/data/comments.json');

// Register the POST /comment route
$router->register('POST', '/comment', [$commentManager, 'handleCommentRequest']);
$router->register('GET', '/comment', [$commentManager, 'handleGetCommentsRequest']);

// Handle the incoming request
$router->handleRequest();
