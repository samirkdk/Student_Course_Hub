<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Module Form</title>
    <link rel="stylesheet" href="assets/css/addmod.css">
</head>
<body>
    <div class="form-container">
        <h2>Add New Modules</h2>
        <form action="post" method="post">
            <div class="form-group">
                <label for="module">Module Name:</label>
                <input type="text" id="module" name="module" required>
            </div>

            <div class="form-group">
                <label for="level">Select Programme:</label>
                <select id="level" name="level" required>
                    <option value="">Select a programme</option>
                    <option value="bachelors">Undergraduate</option>
                    <option value="masters">Postgraduate</option>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Module Description:</label>
                <textarea id="description" name="description" required></textarea>
            </div>

            <div class="form-group">
                <input type="submit" value="Add Module">
            </div>
        </form>
    </div>
</body>
</html>
