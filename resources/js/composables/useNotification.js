import { initializeApp } from "firebase/app";
import { getMessaging, getToken, onMessage } from "firebase/messaging";
import axios from "axios";
import { onMounted } from "vue";

export function useNotification() {
    const firebaseConfig = {
        apiKey: "You_apikey",
        authDomain: "You_projectDoamin",
        projectId: "YouId",
        storageBucket: "",
        messagingSenderId: "",
        appId: "",
        measurementId: "",
    };

    const app = initializeApp(firebaseConfig);
    // const messaging = messaging();
    const messaging = getMessaging(app);

    function getNotificationPermission() {
        Notification.requestPermission();
    }

    function storeFckToken(token) {
        axios.post(route("profile.storeToken"), {
            token: token,
        });
        return;
    }

    const vapidKey = import.meta.env.FIREBASE_KEY;

    onMounted(() => {
        // generate and store token
        getToken(messaging, {
            vapidKey: vapidKey,
        })
            .then((currentToken) => {
                if (currentToken) {
                    storeFckToken(currentToken);
                }
            })
            .catch((error) => {
                getNotificationPermission();
            });

        // send notification
        onMessage(messaging, function ({ notification, data }) {
            let noti = new Notification(notification.title, {
                body: notification.body,
                icon: notification.icon,
                sound: "/sound.wav",
                click_action: data.admin_link,
            });

            let sound = new Audio("/sound.wav");
            sound.play();

            noti.onclick = function (e) {
                e.preventDefault();
                window.open(data.admin_link, "_blank");
            };
        });
    });

    return { getNotificationPermission };
}
