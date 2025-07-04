<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Chat Room</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }
        .chat-container {
            width: 600px;
            margin: auto;
            background-color: #fffac8;
            padding: 20px;
            border: 2px solid blue;
            box-shadow: 2px 2px 8px #ccc;
        }
        .message-box {
            border: 1px solid #ccc;
            height: 300px;
            overflow-y: auto;
            background-color: #ffffe0;
            padding: 10px;
            margin-bottom: 10px;
        }
        .pesan-item {
            margin-bottom: 10px;
        }
        .header {
            font-weight: bold;
        }
        .time {
            font-size: 12px;
            color: #666;
            margin-left: 5px;
        }
        .text {
            margin-left: 10px;
        }
        .form-baris {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }
        input[type="text"] {
            flex: 1;
            padding: 6px;
        }
        button {
            padding: 6px 10px;
        }
    </style>
</head>
<body>

<div class="chat-container">
    <?php if (!isset($_SESSION['username'])): ?>
        <!-- Login Form -->
        <form method="POST">
            <div class="form-baris">
                <input type="text" name="username" placeholder="Masukkan nama Anda" required>
                <button type="submit">Login</button>
            </div>
        </form>
    <?php else: ?>
        <!-- Chat Area -->
        <div class="form-baris" style="justify-content: space-between;">
            <div><strong>Login sebagai:</strong> <?= htmlspecialchars($_SESSION['username']) ?></div>
            <form method="POST">
                <button type="submit" name="logout">Logout</button>
            </form>
        </div>

        <div class="message-box" id="pesan"></div>

        <div class="form-baris">
            <input type="text" id="pesanInput" placeholder="Tulis pesan...">
            <button onclick="kirimPesan()">Kirim</button>
        </div>
    <?php endif; ?>
</div>

<?php
// Handle login & logout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'])) {
        $_SESSION['username'] = $_POST['username'];
        header("Location: index.php");
        exit;
    }
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: index.php");
        exit;
    }
}
?>

<?php if (isset($_SESSION['username'])): ?>
<script>
    const currentUser = <?= json_encode($_SESSION['username']) ?>;

    function waktuSekarang() {
        const now = new Date();
        return now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
    }

    function tambahPesan(user, text, time, id) {
        const container = document.getElementById('pesan');
        let formattedTime = time.includes(' ') ? time.split(' ')[1].substring(0, 5) : time;

        const div = document.createElement('div');
        div.className = 'pesan-item';
        div.innerHTML = `
            <span class="header" style="color:${user === 'Admin' ? 'red' : (user === currentUser ? 'blue' : 'black')}">${user}</span>
            <span class="time">(${formattedTime})</span>: 
            <span class="text">${text}</span>
            ${user === currentUser ? `<button onclick="hapusPesan(${id})" style="margin-left:10px;">🗑️</button>` : ''}
        `;
        container.appendChild(div);
        container.scrollTop = container.scrollHeight;
    }

    function loadPesan() {
        fetch('getMessages.php')
            .then(res => res.json())
            .then(data => {
                const box = document.getElementById('pesan');
                box.innerHTML = '';
                data.messages.pesan.forEach(p => tambahPesan(p.user, p.text, p.time, p.id));
            });
    }

    function kirimPesan() {
        const input = document.getElementById('pesanInput');
        const text = input.value.trim();
        if (!text) return;

        fetch('sendMessage.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                user: currentUser,
                text: text
            })
        }).then(res => res.json())
          .then(data => {
              if (data.status === 'sukses') {
                  input.value = '';
                  loadPesan();
              }
          });
    }

    function hapusPesan(id) {
        if (!confirm("Yakin hapus pesan ini?")) return;

        fetch('deleteMessage.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ id: id })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'sukses') loadPesan();
            else alert('Gagal menghapus pesan.');
        });
    }

    loadPesan();
    setInterval(loadPesan, 5000);
</script>
<?php endif; ?>

</body>
</html>
