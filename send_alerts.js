const functions = require("firebase-functions");
   const admin = require("firebase-admin");
   admin.initializeApp();

   exports.sendHealthCheckupAlert = functions.firestore
     .document("checkups/{checkupId}")
     .onCreate((snap, context) => {
       const newValue = snap.data();

       // Define your alert condition
       if (newValue.results.someResult > someThreshold) {
         const payload = {
           notification: {
             title: "Health Checkup Alert",
             body: "You need to schedule a follow-up appointment."
           }
         };

         return admin.messaging().sendToTopic(`user_${newValue.userId}`, payload)
           .then(response => {
             console.log("Successfully sent message:", response);
           })
           .catch(error => {
             console.log("Error sending message:", error);
           });
       }
       return null;
     });
