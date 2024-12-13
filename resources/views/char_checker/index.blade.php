<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Character Check</title>
</head>
<body>
    <h1>Character Checker</h1>
    <form action="/check" method="POST">
        @csrf
        <label for="input_one">Input 1:</label>
        <input type="text" name="input_one" required>
        <br>
        <label for="input_two">Input 2:</label>
        <input type="text" name="input_two" required>
        <br>
        <button type="submit">Check</button>
    </form>
</body>
</html>
