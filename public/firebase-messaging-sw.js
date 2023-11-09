importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyCwvhY2qCtw3Aa0auw9_gygY6fhqswHzFc",
    projectId: "proapps-d8080",
    messagingSenderId: "921000558886",
    appId: "1:921000558886:web:f368ccf9a9924e4fe501e7"
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    return self.registration.showNotification(title,{body,icon});
});
