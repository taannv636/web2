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
            height: 100vh;
            /* Chiều cao của màn hình */
            margin: 0;
            /* Loại bỏ margin mặc định */
        }
    </style>
    <style>
        /* HTML: <div class="loader"></div> */
        .loader {
            width: 40px;
            height: 40px;
            position: relative;
            --c: no-repeat linear-gradient(#25b09b 0 0);
            background:
                var(--c) center/100% 10px,
                var(--c) center/10px 100%;
        }

        .loader:before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                var(--c) 0 0,
                var(--c) 100% 0,
                var(--c) 0 100%,
                var(--c) 100% 100%;
            background-size: 15.5px 15.5px;
            animation: l16 1.5s infinite cubic-bezier(0.3, 1, 0, 1);
        }

        @keyframes l16 {
            33% {
                inset: -10px;
                transform: rotate(0deg)
            }

            66% {
                inset: -10px;
                transform: rotate(90deg)
            }

            100% {
                inset: 0;
                transform: rotate(90deg)
            }
        }
    </style>

</head>

<body>
    <h1>Sản phẩm này đã bị xóa hoặc không tồn tại.</h1>
    <p>Xin lỗi, sản phẩm này không còn khả dụng để hiển thị.</p>
    <p id="countdown" style="font-size: 50px;">5</p>
    <div class="loader"></div>
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