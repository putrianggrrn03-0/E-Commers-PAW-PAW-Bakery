<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Paw Profile</title>
<style>
    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background-color: #f9f6f1; /* cream */
        color: #000;
        overflow-x: hidden;
    }

    .container {
        width: 90%;
        max-width: 400px;
        margin: 30px auto;
        background-color: #fff;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .profile {
        text-align: center;
        position: relative;
    }

    .profile img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        background-color: #d9c7b1;
    }

    .edit-icon {
        position: absolute;
        top: 45px;
        right: 120px;
        background-color: #3e2c20; /* dark brown */
        border-radius: 50%;
        padding: 5px;
        cursor: pointer;
    }

    .edit-icon img {
        width: 20px;
        height: 20px;
        filter: invert(1);
    }

    h2 {
        margin-top: 10px;
        margin-bottom: 5px;
    }

    .edit-text {
        color: #3e2c20;
        font-weight: bold;
        text-decoration: underline;
        cursor: pointer;
    }

    .menu {
        margin-top: 30px;
    }

    .menu button {
        display: block;
        width: 100%;
        padding: 15px;
        background-color: #f2e8dd;
        border: none;
        border-radius: 10px;
        margin-bottom: 15px;
        font-size: 16px;
        cursor: pointer;
        text-align: left;
    }

    .menu button:hover {
        background-color: #e5d8c9;
    }

    .section {
        background-color: #f2e8dd;
        border-radius: 10px;
        padding: 15px;
        margin-top: 20px;
        font-size: 14px;
    }

    input[type="file"] {
        display: none;
    }

    /* POPUP */
    .popup {
        position: fixed;
        bottom: -100%;
        left: 0;
        width: 97%;
        background-color: #fff;
        border-radius: 20px 20px 0 0;
        box-shadow: 0 -3px 15px rgba(0,0,0,0.2);
        transition: bottom 0.4s ease-in-out;
        max-height: 60%;
        overflow-y: auto;
        padding: 20px;
        z-index: 100;
    }

    .popup.active {
        bottom: 0;
    }

    .popup h3 {
        margin-top: 0;
        color: #3e2c20;
    }

    .popup button.close {
        background-color: #3e2c20;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 8px;
        cursor: pointer;
        display: block;
        margin: 20px auto 0;
    }

    .setting-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #ddd;
    }

    select, input[type="text"] {
        padding: 6px;
        border-radius: 5px;
        border: 1px solid #aaa;
    }

    button.action {
        background-color: #3e2c20;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 5px;
        cursor: pointer;
    }

    button.action:hover {
        background-color: #6b4f3b;
    }
</style>
</head>
<body>

<div class="container">
    <div class="profile">
        <img id="profile-pic" src="https://via.placeholder.com/100" alt="Profile Picture">
        <label for="upload" class="edit-icon">
            <img src="7DE02A2D-E342-4608-A468-7B0BA3E7FA91.jpeg" alt="Edit">
        </label>
        <input type="file" id="upload" accept="image/*" onchange="changeProfile(event)">
        <h2 id="userName">Hanna Binje</h2>
        <p class="edit-text" onclick="openPopup('editPopup')">Edit Info</p>
    </div>

    <div class="menu">
        <button onclick="openPopup('settingsPopup')">⚙ Settings</button>
        <button onclick="openPopup('aboutPopup')">ℹ About Us</button>
    </div>

    <div class="section">
        <p><b>Your data is protected:</b> Your privacy is our top priority. We never sell your data and you can delete it anytime.</p>
    </div>
</div>

<!-- EDIT INFO POPUP -->
<div id="editPopup" class="popup">
    <h3>Edit Info</h3>
    <div class="setting-item">
        <span>Name</span>
        <input type="text" id="newName" placeholder="Enter new name">
    </div>
    <button class="action" onclick="saveName()">Save</button>
    <button class="close" onclick="closePopup('editPopup')">Close</button>
</div>

<!-- SETTINGS POPUP -->
<div id="settingsPopup" class="popup">
    <h3>Settings</h3>
    <div class="setting-item">
        <span>Language</span>
        <select id="language" onchange="changeLanguage()">
            <option value="en">English</option>
            <option value="id">Bahasa Indonesia</option>
        </select>
    </div>
    <div class="setting-item">
        <span>Clear Downloads</span>
        <button class="action" onclick="clearStorage('download')">Clear</button>
    </div>
    <div class="setting-item">
        <span>Clear Cache</span>
        <button class="action" onclick="clearStorage('cache')">Clear</button>
    </div>
    <button class="close" onclick="closePopup('settingsPopup')">Close</button>
</div>

<!-- ABOUT US POPUP -->
<div id="aboutPopup" class="popup">
    <h3>About Paw App 🐾</h3>
    <p>
        Paw App adalah aplikasi yang mengutamakan kenyamanan dan privasi pengguna.  
        Dengan desain lembut dan hangat, aplikasi ini membantu kamu menjaga data pribadi tetap aman.  
        Kami tidak pernah menjual data pengguna, dan kamu bisa menghapusnya kapan saja.
    </p>
    <button class="close" onclick="closePopup('aboutPopup')">Close</button>
</div>

<script>
function changeProfile(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('profile-pic').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

function openPopup(id) {
    document.getElementById(id).classList.add('active');
}

function closePopup(id) {
    document.getElementById(id).classList.remove('active');
}

function changeLanguage() {
    const lang = document.getElementById("language").value;
    if (lang === "id") alert("Bahasa diubah ke Bahasa Indonesia 🇮🇩");
    else alert("Language changed to English 🇬🇧");
}

function clearStorage(type) {
    alert(type === 'cache' ? 'Cache cleared successfully!' : 'Downloads cleared successfully!');
}

function saveName() {
    const newName = document.getElementById('newName').value.trim();
    if (newName) {
        document.getElementById('userName').textContent = newName;
        closePopup('editPopup');
    } else {
        alert("Please enter a name before saving.");
    }
}
</script>

</body>
</html>