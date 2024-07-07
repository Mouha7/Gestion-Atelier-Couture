import { ApproModel } from "../models/ApproModel.js"

document.addEventListener("DOMContentLoaded", async (e) => {
    const approModel = new ApproModel();
    alert("ok");
    let response = await approModel.getAllArticles();
    console.log(response);

})