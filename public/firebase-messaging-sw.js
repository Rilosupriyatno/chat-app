// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.
importScripts("https://www.gstatic.com/firebasejs/7.9.1/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/7.9.1/firebase-messaging.js");

// Initialize the Firebase app in the service worker by passing in
// your app's Firebase config object.
// https://firebase.google.com/docs/web/setup#config-object
firebase.initializeApp({
    apiKey: "AIzaSyDOjjuqGkFJLA1knMgYmLJ3IlsqF0XTmhc",
    authDomain: "chatings-d2039.firebaseapp.com",
    databaseURL: "https://chatings-d2039.firebaseio.com",
    projectId: "chatings-d2039",
    storageBucket: "chatings-d2039.appspot.com",
    messagingSenderId: "494435571245",
    appId: "1:494435571245:web:893893b18e2ce406810aa4",
    measurementId: "G-0MFSSVY6KK",
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler((payload) => {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload
    );
    // Customize notification here
    const { title, body } = payload.notification;
    const notificationOptions = {
        body,
    };

    self.registration.showNotification(title, notificationOptions);
});
