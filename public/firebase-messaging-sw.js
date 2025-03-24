importScripts(
    "https://www.gstatic.com/firebasejs/10.0.0/firebase-app-compat.js"
);
importScripts(
    "https://www.gstatic.com/firebasejs/10.0.0/firebase-messaging-compat.js"
);

firebase.initializeApp({
    apiKey: "AIzaSyCrzyvOM0aBFCuXr3VeK",
    authDomain: "ikon-mart.firebaseapp.com",
    projectId: "ikon-mart",
    storageBucket: "ikon-mart.appspot.com",
    messagingSenderId: "847383826079",
    appId: "1:847383826079:web:e78d8f9995b942aba39caa",
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(({ notification }) => {
    console.log("[firebase-messaging-sw.js] Received background message ");
    // Customize notification here
    const notificationTitle = notification.title;
    const notificationOptions = {
        body: notification.body,
    };

    if (notification.icon) {
        notificationOptions.icon = notification.icon;
    }

    if (notification.sound) {
        notificationOptions.sound = notification.sound;
    }

    self.registration.showNotification(notificationTitle, notificationOptions);
});
