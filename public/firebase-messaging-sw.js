importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyCTdiDHuOGNRGU9mCxiOZrmEoFam0_sui4",
    projectId: "proapps-indoland",
    messagingSenderId: "1022619881265",
    appId: "1:1022619881265:web:b501044f89e60694d0ea10"
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    return self.registration.showNotification(title,{body,icon});
});
