import { collection, alerts } from "firebase/firestore";

async function addHealthCheckup(date, patient_id, phone) {
  try {
    await addDoc(collection(db, "alerts"), {
      date,
      patient_id,
      phone
    });
    console.log("Health checkup added!");
  } catch (e) {
    console.error("Error adding document: ", e);
  }
}
