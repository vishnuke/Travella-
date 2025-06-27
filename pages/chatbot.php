<?php
session_start();

// Handle POST request (AJAX message submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $userMessage = trim($_POST['message'] ?? '');

    if (!isset($_SESSION['chat_memory'])) {
        $_SESSION['chat_memory'] = [];
    }

    $_SESSION['chat_memory'][] = ['sender' => 'user', 'message' => $userMessage];

    // 🔗 Call Ollama's TinyLlama model
    $payload = json_encode([
        'model' => 'tinyllama',
        'prompt' => $userMessage,
        'stream' => false
    ]);

    $context = stream_context_create([
        'http' => [
            'method'  => 'POST',
            'header'  => "Content-Type: application/json\r\n",
            'content' => $payload
        ]
    ]);

    $ollamaResponse = file_get_contents('http://localhost:11434/api/generate', false, $context);
    $ollamaData = json_decode($ollamaResponse, true);

    $botReply = $ollamaData['response'] ?? "_Sorry, I couldn't generate a response._";

    $_SESSION['chat_memory'][] = ['sender' => 'bot', 'message' => $botReply];

    // Keep only the last 10 messages
    $_SESSION['chat_memory'] = array_slice($_SESSION['chat_memory'], -10);

    echo json_encode(['reply' => $botReply]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>AI Travel Chatbot</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
  <style>
    body {
      background-color: #f0f2f5;
    }
    .chat-container {
      max-width: 700px;
      margin: 50px auto;
      padding: 20px;
      height: 75vh;
      overflow-y: auto;
      background: #ffffff;
      border-radius: 15px;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
    }
    .chat-bubble {
      padding: 10px 15px;
      margin: 8px;
      border-radius: 20px;
      max-width: 75%;
      white-space: pre-wrap;
    }
    .user {
      background-color: #dcf8c6;
      margin-left: auto;
      text-align: right;
    }
    .bot {
      background-color: #f1f0f0;
      margin-right: auto;
      text-align: left;
    }
  </style>
</head>
<body>

<div class="chat-container d-flex flex-column" id="chatBox">
  <?php if (!empty($_SESSION['chat_memory'])): ?>
    <?php foreach ($_SESSION['chat_memory'] as $entry): ?>
      <div class="chat-bubble <?= $entry['sender'] ?>">
        <?= nl2br(htmlspecialchars($entry['message'])) ?>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<div class="container mt-3">
  <form id="chatForm" class="d-flex">
    <input type="text" id="message" name="message" class="form-control me-2" placeholder="Ask something..." required>
    <button type="submit" class="btn btn-primary">Send</button>
  </form>
</div>

<script>
  const form = document.getElementById('chatForm');
  const chatBox = document.getElementById('chatBox');
  const input = document.getElementById('message');

  // Auto-scroll to bottom on load
  window.onload = () => {
    chatBox.scrollTop = chatBox.scrollHeight;
  };

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const message = input.value.trim();
    if (!message) return;

    appendMessage(message, 'user');
    input.value = '';

    // Show loading message
    const loadingBubble = appendMessage("Thinking...", 'bot');

    try {
      const response = await fetch('chatbot.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `message=${encodeURIComponent(message)}`
      });

      const data = await response.json();
      loadingBubble.remove(); // Remove "Thinking..."
      appendMessage(data.reply, 'bot');
    } catch (error) {
      loadingBubble.remove();
      appendMessage("_Oops! Something went wrong. Please try again._", 'bot');
    }
  });

  function appendMessage(message, sender) {
    const bubble = document.createElement('div');
    bubble.classList.add('chat-bubble', sender);
    bubble.innerHTML = marked.parse(message);
    chatBox.appendChild(bubble);
    chatBox.scrollTop = chatBox.scrollHeight;
    return bubble;
  }
</script>

</body>
</html>
