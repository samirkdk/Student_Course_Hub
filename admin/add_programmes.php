<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Programme Form</title>
    <link rel="stylesheet" href="assets/css/addpro.css">
</head>
<body>
    <div class="form-container">
        <h2>Add New Programme</h2>
        <form action="#" method="post">
            <div class="form-group">
                <label for="programme">Programme Name:</label>
                <input type="text" id="programme" name="programme" required>
            </div>

            <div class="form-group">
                <label for="level">Programme Level:</label>
                <select id="level" name="level" required>
                    <option value="">Select a level</option>
                    <option value="bachelors">Undergraduate</option>
                    <option value="masters">Postgraduate</option>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Programme Description:</label>
                <textarea id="description" name="description" required></textarea>
            </div>

            <div class="form-group">
                <input type="submit" value="Add Programme">
            </div>
        </form>
    </div>
</body>
</html>
