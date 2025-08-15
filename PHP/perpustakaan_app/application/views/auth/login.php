<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Perpustakaan</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #ffffff;
            padding: 2.5rem;
            border-radius: 0.75rem; /* rounded-xl */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* shadow-lg */
            width: 100%;
            max-width: 400px;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db; /* border-gray-300 */
            border-radius: 0.375rem; /* rounded-md */
            margin-top: 0.25rem;
            margin-bottom: 1rem;
            box-sizing: border-box;
        }
        .form-button {
            width: 100%;
            padding: 0.75rem;
            background-color: #3b82f6; /* bg-blue-500 */
            color: white;
            border-radius: 0.375rem; /* rounded-md */
            font-weight: 600; /* font-semibold */
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-button:hover {
            background-color: #2563eb; /* bg-blue-600 */
        }
        .alert {
            padding: 0.75rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }
        .alert-error {
            background-color: #fee2e2; /* bg-red-100 */
            color: #ef4444; /* text-red-500 */
            border: 1px solid #fca5a5; /* border-red-300 */
        }
        .alert-success {
            background-color: #d1fae5; /* bg-green-100 */
            color: #10b981; /* text-green-500 */
            border: 1px solid #6ee7b7; /* border-green-300 */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login Perpustakaan</h2>

        <!-- Pesan error atau sukses dari flashdata -->
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-error">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <!-- Form Login -->
        <?php echo form_open('auth/authenticate', ['class' => 'space-y-4']); ?>
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" id="username" name="username" class="form-input" required>
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" class="form-input" required>
            </div>
            <div>
                <button type="submit" class="form-button">Login</button>
            </div>
        <?php echo form_close(); ?>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">Atau, cari buku tanpa login:</p>
            <a href="<?php echo site_url('student_view/book_search'); ?>" class="inline-block mt-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-md text-sm font-semibold transition duration-300">
                Cari Buku
            </a>
        </div>
    </div>
</body>
</html>
