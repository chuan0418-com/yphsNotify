importScripts("https://www.gstatic.com/firebasejs/10.14.0/firebase-app-compat.js")
importScripts("https://www.gstatic.com/firebasejs/10.14.0/firebase-messaging-compat.js")

var firebaseConfig = {
    apiKey: "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX",
    authDomain: "X.firebaseapp.com",
    projectId: "XXX",
    storageBucket: "XXX.appspot.com",
    messagingSenderId: "XXXXXXXXXXXX",
    appId: "X:XXXXXXXXXXXX:web:XXXXXXXXXXXXXXXXXXXXXX",
    measurementId: "G-XXXXXXXXXX"
};
firebase.initializeApp(firebaseConfig);


const messaging = firebase.messaging();

// var click_action;

// 監聽notifiction點擊事件
self.addEventListener('notificationclick', function(event) {
  var url = click_action;
  event.notification.close();
  event.waitUntil(
    clients.matchAll({
      type: 'window'
    }).then(windowClients => {
      // 如果tab是開著的，就 focus 這個tab
      for (var i = 0; i < windowClients.length; i++) {
        var client = windowClients[i];
        if(client.url === url && 'focus' in client) {
          return client.focus();
        }
      }
      // 如果沒有，就新增tab
      if(clients.openWindow) {
        return clients.openWindow(click_action);
      }
    })
  );
});

// FCM
// messaging.setBackgroundMessageHandler(function(payload) {
//   var data = payload.data;
//   var title = data.title;
//   var options = {
//     body: data.body,
//   };
//   click_action = data.click_action;

//   return self.registration.showNotification(title, options);
// });

messaging.onBackgroundMessage(function(payload) {
    //   console.log('[firebase-messaging-sw.js] Received background message ', payload);
      console.log('[firebase-messaging-sw.js] PAYLOAD NOTIFICATION: ', payload.notification);
      // Customize notification here
      const notificationTitle = payload.notification.title
      const notificationOptions = {
        body: payload.notification.body,
        icon: payload.notification.image
      };
    
      self.registration.showNotification(notificationTitle,
        notificationOptions);
    }); 