/*userlogin.html*/
// script.js

document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById("loginForm");
    if (loginForm) {
      loginForm.addEventListener("submit", function (e) {
        e.preventDefault();
  
        const username = document.getElementById("username").value.trim();
        const password = document.getElementById("password").value.trim();
        const error = document.getElementById("loginError");
  
        // Dummy database user
        const users = [
          { username: "admin", password: "admin123", role: "admin" },
          { username: "afianada", password: "1234", role: "user" },
          { username: "narumi", password: "5678", role: "user" },
          { username: "hirotaka", password: "abcd", role: "user" }
        ];
  
        const foundUser = users.find(
          (user) => user.username === username && user.password === password
        );
  
        if (foundUser) {
          localStorage.setItem("loggedInUser", JSON.stringify(foundUser));
  
          if (foundUser.role === "admin") {
            window.location.href = "file:///C:/Users/HP/Documents/PhotoShare/admin/admin.html";
          } else {
            window.location.href = "userfeed.html";
          }
        } else {
          error.textContent = "Username atau password salah!";
        }
      });
    }
  });
  

// userprofile.js
const dummyPhotos = [
    "https://picsum.photos/300?random=1",
    "https://picsum.photos/300?random=2",
    "https://picsum.photos/300?random=3",
    "https://picsum.photos/300?random=4",
    "https://picsum.photos/300?random=5"
  ];
  
  function loadPhotos() {
    const grid = document.getElementById('photoGrid');
    grid.innerHTML = ''; // Clear any existing photos
    dummyPhotos.forEach(url => {
      const img = document.createElement('img');
      img.src = url;
      img.classList.add('photo-item'); // Add class for styling if needed
      grid.appendChild(img);
    });
  }
  
  function switchTab(tabId) {
    document.querySelectorAll('.tab').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
  
    const tab = document.querySelector(`.tab[onclick*='${tabId}']`);
    const content = document.getElementById(tabId);
  
    if (tab && content) {
      tab.classList.add('active');
      content.classList.add('active');
    }
  }
  
  function uploadPhoto(event) {
    event.preventDefault();
    const input = document.getElementById('photoInput');
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function (e) {
        const img = document.createElement('img');
        img.src = e.target.result;
        img.classList.add('photo-item'); // Add class for styling
        document.getElementById('photoGrid').appendChild(img);
        switchTab('photos');
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  function logout() {
    // Simulasi logout
    alert("Anda telah logout.");
    window.location.href = 'login.html';
  }
  
  // Use DOMContentLoaded instead of window.onload to ensure all elements are loaded before execution
  document.addEventListener('DOMContentLoaded', function () {
    loadPhotos(); // Load user profile photos
  });
  
  /*usereditprofile.js*/
  function logout() {
    alert("Anda telah logout.");
    window.location.href = 'login.html';
  }

  function saveProfile(event) {
    event.preventDefault();
    alert("Profil berhasil diperbarui!");
    window.location.href = 'userprofile.html';
  }