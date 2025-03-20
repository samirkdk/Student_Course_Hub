<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Course Hub</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Available Programmes</h1>
    <input type="text" id="search" placeholder="Search programmes...">
    <div id="programmes"></div>

    <script>
        fetch('get_programmes.php')
        .then(response => response.json())
        .then(data => {
            let container = document.getElementById('programmes');
            data.forEach(prog => {
                container.innerHTML += `<div>
                    <h3>${prog.name}</h3>
                    <p>${prog.description}</p>
                    <a href="programme.php?id=${prog.id}">View Details</a>
                </div>`;
            });
        });

        document.getElementById('search').addEventListener('keyup', function() {
            let value = this.value.toLowerCase();
            document.querySelectorAll('#programmes div').forEach(prog => {
                prog.style.display = prog.textContent.toLowerCase().includes(value) ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>
