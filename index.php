<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/main.css">
  <title>Avril Voucher</title>
</head>
<body>
  <div class="wrapper">
    <img src="logo.png" alt="">

    <form action="app.php" method="post" enctype="multipart/form-data">
      <label for="idioma">Paso 1: Escoge el idioma.</label>
      <select name="idioma" id="">
        <option value="en">Inglés</option>
        <option value="br">Portugues</option>
      </select>

      <label for="plan">Paso 2: Escoge el plan.</label>
      <select name="plan" id="">
        <option value="inf-15">Infinity 15</option>
        <option value="inf-25">Infinity 25</option>
        <option value="25-pro">Infinity 25 Protect</option>
        <option value="30-proEU">Infinity 30 Europe</option>
        <option value="40-proEU">Infinity 40 Europe</option>
        <option value="inf40-proEU">Infinity 40 Europe Protect</option>
        <option value="inf-40">Infinity 40</option>
        <option value="40-pro">Infinity 40 Protect</option>
        <option value="inf-60">Infinity 60</option>
        <option value="60-pro">Infinity 60 Protect</option>
        <option value="inf-80">Infinity 80</option>
        <option value="80-pro">Infinity 80 Protect</option>
        <option value="reg-25">Infinity Regional 25</option>
        <option value="reg-40">Infinity Regional 40</option>
        <option value="reg-25-pro">Regional 25 Protect</option>
        <option value="reg-40-pro">Regional 40 Protect</option>
        <option value="pre-50-pro">Premium Europe 50 Protect</option>
        <option value="pre-60-pro">Premium 60 Protect</option>
        <option value="pre-80-pro">Premium 80 Protect</option>
        <option value="pre-100-pro">Premium 100 Protect</option>
        <option value="pre-150-pro">Premium 150 Protect</option>
        <option value="pre-250-pro">Premium 250 Protect</option>
      </select>

      <label for="file">Paso 3: Escoge el archivo (formato PDF).</label>
      <input type="file" name="userfile" id="userfile">

      <label for="submit">Paso 4: Hace click</label>
      <input class="procesar" type="submit" name="submit" value="Procesar">
    </form>
  </div>

</body>
</html>