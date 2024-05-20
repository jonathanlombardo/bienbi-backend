import axios from "axios";
import { Chart } from "chart.js";

let params = {
    authToken: authToken,
    dtStart: "2023-11-18 00:00:00",
    dtEnd: "2023-05-18 23:59:59",
    period: "month",
};

axios.get("http://127.0.0.1:8000/api/charts", { params }).then((res) => {
    console.log(res.data);
});
