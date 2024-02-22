<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }

    .back-button {
        margin-top: 1rem;
        margin-left: 1rem;
      display: inline-block;
      padding: 10px 20px;
      font-size: 20px;
      text-decoration: none;
      color: #fff;
      background-color: #3498db;
      border-radius: 5px;
      transition: background-color 0.3s ease;
      margin-bottom: -5em;
    }

   

    .back-button:hover {
      background-color: #2980b9;
    }
  </style>
</head>
<body>

  <a href="#" class="back-button" onclick="goBack()">←</a>

  <script>
    function goBack() {
      window.history.back();
    }
  </script>

</body>
</html>
