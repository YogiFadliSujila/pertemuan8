<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Glass Todo List</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        /* --- CSS VARIABLES & RESET --- */
        :root {
            --glass-bg: rgba(255, 255, 255, 0.15);
            --glass-border: 1px solid rgba(255, 255, 255, 0.2);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            --primary-color: #4facfe;
            --secondary-color: #00f2fe;
            --text-color: #fff;
            --danger-color: #ff5e62;
            --success-color: #00b09b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* --- BACKGROUND ANIMATION --- */
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(45deg, #1a1a2e, #16213e);
            overflow: hidden; /* Mencegah scrollbar karena elemen background */
        }

        /* Elemen dekorasi background (blobs) */
        .circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            animation: float 6s ease-in-out infinite;
        }

        .circle-1 {
            width: 300px;
            height: 300px;
            background: var(--primary-color);
            top: -50px;
            left: -50px;
        }

        .circle-2 {
            width: 400px;
            height: 400px;
            background: #ff00cc;
            bottom: -100px;
            right: -50px;
            animation-delay: -3s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(30px); }
        }

        /* --- GLASS CONTAINER --- */
        .container {
            width: 90%;
            max-width: 500px;
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: var(--glass-border);
            border-radius: 20px;
            box-shadow: var(--glass-shadow);
            padding: 30px;
            color: var(--text-color);
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
            letter-spacing: 1px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        /* --- FORM INPUT --- */
        #add-form {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }

        input[type="text"] {
            flex: 1;
            padding: 12px 20px;
            border-radius: 30px;
            border: none;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            outline: none;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: 0.3s;
        }

        input[type="text"]::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        input[type="text"]:focus {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 10px rgba(79, 172, 254, 0.5);
        }

        button[type="submit"] {
            padding: 12px 25px;
            border-radius: 30px;
            border: none;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        button[type="submit"]:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 242, 254, 0.4);
        }

        /* --- TODO LIST ITEMS --- */
        ul {
            list-style: none;
            max-height: 400px;
            overflow-y: auto;
            padding-right: 5px;
        }

        /* Custom Scrollbar */
        ul::-webkit-scrollbar {
            width: 5px;
        }
        ul::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 10px;
        }

        li {
            background: rgba(255, 255, 255, 0.05);
            margin-bottom: 12px;
            padding: 15px;
            border-radius: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
            animation: fadeIn 0.5s ease;
        }

        li:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        li span.task-text {
            flex-grow: 1;
            font-size: 1rem;
            word-break: break-all;
        }

        /* Tombol Aksi (Icon) */
        .actions {
            display: flex;
            gap: 10px;
            margin-left: 10px;
        }

        .btn-action {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            color: white;
            transition: 0.3s;
            font-size: 0.9rem;
        }

        .complete {
            background: rgba(0, 176, 155, 0.2);
            color: var(--success-color);
        }
        .complete:hover {
            background: var(--success-color);
            color: white;
        }

        .delete {
            background: rgba(255, 94, 98, 0.2);
            color: var(--danger-color);
        }
        .delete:hover {
            background: var(--danger-color);
            color: white;
        }

        /* Animasi Masuk */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Status Selesai */
        .completed-task {
            text-decoration: line-through;
            opacity: 0.6;
            color: rgba(255,255,255,0.5);
        }
    </style>

    <script>
        $(document).ready(function () {
            // Fungsi Load Todos
            function loadTodos() {
                // Efek loading sederhana pada icon button submit
                $('button[type="submit"]').html('<i class="fas fa-spinner fa-spin"></i>');

                $.get('api.php?action=list', function (data) {
                    const todoList = $('#todo-list');
                    todoList.empty();

                    // Kembalikan tombol Add
                    $('button[type="submit"]').text('Add');

                    // Jika data kosong
                    if(data.length === 0) {
                        todoList.append('<div style="text-align:center; opacity:0.6; padding:20px;">No tasks yet. Start by adding one!</div>');
                        return;
                    }

                    data.forEach(function (todo) {
                        const li = $('<li>');
                        
                        // Cek status completed untuk styling teks
                        const taskClass = todo.is_completed == 1 ? 'task-text completed-task' : 'task-text';
                        const checkIcon = todo.is_completed == 1 ? '<i class="fas fa-check-circle" style="color:var(--success-color); margin-right:10px;"></i>' : '';

                        let htmlContent = `
                            <span class="${taskClass}">
                                ${checkIcon} ${todo.task}
                            </span>
                            <div class="actions">
                        `;

                        // Hanya tampilkan tombol ceklis jika belum selesai
                        if (todo.is_completed == 0) { // Pastikan logika ini sesuai database (0/1 atau false/true)
                            htmlContent += `
                                <a href="#" class="btn-action complete" data-id="${todo.id}" title="Mark as Completed">
                                    <i class="fas fa-check"></i>
                                </a>
                            `;
                        }

                        htmlContent += `
                                <a href="#" class="btn-action delete" data-id="${todo.id}" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        `;

                        li.html(htmlContent);
                        todoList.append(li);
                    });
                }).fail(function() {
                    alert("Gagal terhubung ke API. Pastikan server lokal berjalan.");
                    $('button[type="submit"]').text('Add');
                });
            }

            // --- LOGIKA UTAMA (Sama seperti kode asli, hanya sedikit penyesuaian UI) ---

            $('#add-form').submit(function (e) {
                e.preventDefault();
                const taskInput = $('#task');
                const task = taskInput.val();

                if(task.trim() === "") return; // Mencegah input kosong

                $.post('api.php?action=add', JSON.stringify({ task: task }), function () {
                    taskInput.val('');
                    loadTodos();
                });
            });

            $(document).on('click', '.complete', function (e) {
                e.preventDefault(); // Mencegah scroll ke atas
                const id = $(this).data('id');
                
                // Efek UI instan sebelum reload
                $(this).closest('li').find('.task-text').css('text-decoration', 'line-through');

                $.ajax({
                    url: 'api.php?action=complete',
                    type: 'PUT',
                    data: JSON.stringify({ id: id }),
                    success: loadTodos
                });
            });

            $(document).on('click', '.delete', function (e) {
                e.preventDefault();
                if(!confirm('Are you sure you want to delete this task?')) return;

                const id = $(this).data('id');
                const li = $(this).closest('li');

                // Animasi hapus sebelum request
                li.fadeOut(300, function() {
                    $.ajax({
                        url: 'api.php?action=delete',
                        type: 'DELETE',
                        data: JSON.stringify({ id: id }),
                        success: loadTodos
                    });
                });
            });

            loadTodos();
        });
    </script>
</head>
<body>

    <div class="circle circle-1"></div>
    <div class="circle circle-2"></div>

    <div class="container">
        <h1><i class="fas fa-tasks"></i> Todo List</h1>
        
        <form id="add-form">
            <input type="text" id="task" placeholder="What needs to be done?" autocomplete="off">
            <button type="submit">Add</button>
        </form>

        <ul id="todo-list">
            </ul>
    </div>

</body>
</html>