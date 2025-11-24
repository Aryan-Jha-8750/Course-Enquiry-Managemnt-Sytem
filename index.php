<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Enquiry</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container">

        <!-- Top bar with title and Admin Login button -->
        <div class="topbar">
            <div class="logo-text">Course Enquiry Portal</div>
            <a href="admin_login.php" class="admin-link">Admin Login</a>
        </div>

        <!-- Enquiry Form Card -->
        <div class="card">
            <h2>Course Enquiry Form</h2>
            <form action="view.php" method="POST">
                <select name="course" class="inputp" required>
                    <option value="">-- Select Course --</option>
                    <option value="Digital Marketing">Digital Marketing</option>
                    <option value="Web Designing">Web Designing</option>
                    <option value="Web Development">Web Development</option>
                </select>

                <input type="text" name="name" class="inputp" placeholder="Enter Your Name" required>

                <input type="text" name="contact" class="inputp" placeholder="Enter Your Contact Number" required>

                <input type="email" name="email" class="inputp" placeholder="Enter Your Email" required>

                <textarea name="message" rows="4" class="inputp" placeholder="Enter Your Address" required></textarea>

                <button type="submit" class="btn">Submit</button>
            </form>
        </div>

    </div>

    <!-- Chatbot Widget (Groq backend via chatbot.php) -->
    <div class="chatbot-container">
        <div class="chat-window">
            <div class="chat-header">Course Assistant</div>
            <div id="chat-messages" class="chat-messages">
                <div><strong>Bot:</strong> Hi! How can I help you with courses or enquiries today?</div>
            </div>
            <form id="chat-form" class="chat-form">
                <input type="text" id="chat-input" class="chat-input" placeholder="Type a message...">
                <button type="submit" class="chat-send-btn">Send</button>
            </form>
        </div>
    </div>

    <script>
    document.getElementById('chat-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const input = document.getElementById('chat-input');
        const text = input.value.trim();
        if (!text) return;

        const messagesDiv = document.getElementById('chat-messages');

        const userMsg = document.createElement('div');
        userMsg.innerHTML = '<strong>You:</strong> ' + text;
        messagesDiv.appendChild(userMsg);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;

        input.value = '';

        const botMsg = document.createElement('div');
        botMsg.innerHTML = '<strong>Bot:</strong> typing...';
        messagesDiv.appendChild(botMsg);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;

        try {
            const formData = new FormData();
            formData.append('message', text);

            const res = await fetch('chatbot.php', {
                method: 'POST',
                body: formData
            });

            const data = await res.json();
            botMsg.innerHTML = '<strong>Bot:</strong> ' + (data.reply || 'Sorry, no response.');
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        } catch (err) {
            botMsg.innerHTML = '<strong>Bot:</strong> Error talking to server.';
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }
    });
    </script>

</body>
</html>
