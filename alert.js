// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyCaeWJ397P5BQc5kRY3IwrHOTOO7E_lOYk",
  authDomain: "herhealthid.firebaseapp.com",
  projectId: "herhealthid",
  storageBucket: "herhealthid.appspot.com",
  messagingSenderId: "734522876977",
  appId: "1:734522876977:web:85de0d8f336abf502fa110",
  measurementId: "G-K526YWTP9D"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);


document.getElementById('alertButton').addEventListener('click', function() {
    // Get the current time
    const now = new Date();
    const currentHour = now.getHours();

    // Define the time condition (e.g., between 9 AM and 5 PM)
    if (currentHour >= 9 && currentHour <= 17) {
        alert('Alert: Time condition met!');
    } else {
        alert('Alert: Time condition not met.');
    }
});