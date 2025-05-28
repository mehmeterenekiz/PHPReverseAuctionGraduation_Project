<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Site Bakımda</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Roboto', sans-serif;
      background-color: #f4f4f4;
      color: #333;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      text-align: center;
    }
    .maintenance-container {
      background: #fff;
      padding: 40px 30px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .maintenance-container h1 {
      font-size: 2rem;
      margin-bottom: 20px;
      color: #2553a1;
    }
    .maintenance-container p {
      font-size: 1.1rem;
    }
    .gear {
      font-size: 3rem;
      color: #e67e22;
      margin-bottom: 20px;
      animation: spin 2s linear infinite;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
</head>
<body>
  <div class="maintenance-container">
    <div class="gear">⚙️</div>
    <h1>Bakımdayız!</h1>
    <p>Şu anda sitemizde planlı bir bakım çalışması yapılmaktadır.<br>
    Lütfen daha sonra tekrar ziyaret edin.</p>
  </div>
</body>
</html>
