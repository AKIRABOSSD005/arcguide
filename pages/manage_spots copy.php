
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- manage_spot.php -->
<form id="editForm">
    <label>Spot Name:</label>
    <input type="text" name="name" id="name" oninput="updatePreview()" />
    
    <label>Description:</label>
    <textarea name="description" id="description" oninput="updatePreview()"></textarea>
    
    <button type="submit">Save Changes</button>
</form>

<h3>Live Preview</h3>
<iframe id="preview" src="spots.php?preview=true" width="100%" height="400px"></iframe>

<script>
function updatePreview() {
    const name = document.getElementById('name').value;
    const description = document.getElementById('description').value;

    // Pass values to preview via query params
    const iframe = document.getElementById('preview');
    iframe.src = `spots.php?preview=true&name=${encodeURIComponent(name)}&description=${encodeURIComponent(description)}`;
}
</script>

</body>
</html>