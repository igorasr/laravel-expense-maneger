<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Email</title>
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
      body {
        width: 100vw;
        height: 100vh;
        font-family: Arial, sans-serif;
        background-color: #bde0fe;
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .container {
        min-width: 600px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      }

      #header {
        width: 100%;
        height: 4rem;
        background-color: #267ffa;
        padding: 1rem;
      }

      #body {
        padding: 1rem;
      }

      .tittle {
        font-weight: bold;
        color: white;
        font-size: 1.5rem;
      }

      h1 {
        font-size: 1.5rem;
      }

      p {
        font-size: 16px;
        color: #666;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div id="header">
        <p class="tittle">New Expense create</p>
      </div>
      <div id="body">
        <h1>Info</h1>
        <br>
        <p>Owner: {{ $name }}</p>
        <p>Description: {{description}}</p>
        <p>Date: {{date}}</p>
      </div>
    </div>
  </body>
</html>
