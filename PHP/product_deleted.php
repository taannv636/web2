<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm đã bị xóa</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Chiều cao của màn hình */
            margin: 0; /* Loại bỏ margin mặc định */
        }
    </style>
</head>
<body>
    <h1>Sản phẩm này đã bị xóa hoặc không tồn tại.</h1>
    <p>Xin lỗi, sản phẩm này không còn khả dụng để hiển thị.</p>
    <p id="countdown" style="font-size: 50px;">5</p>

    <script>
        let countdownElement = document.getElementById('countdown');
        let count = 5;
        
        function countdown() {
            countdownElement.textContent = count;
            count--;

            if (count < 0) {
                window.location.href = 'index.php';
            } else {
                setTimeout(countdown, 1000);
            }
        }

        countdown();
    </script>
</body>
</html>
