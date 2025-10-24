import axios from "axios";

document.querySelectorAll(".save-btn").forEach((button) => {
    button.addEventListener("click", async (e) => {
        const savableType = e.target.dataset.savableType;
        const savableId = e.target.dataset.savableId;
        const saved = e.target.dataset.saved;

        console.log(saved);

        const response = await axios.post(
            "/api/saves",
            JSON.stringify({
                savable_type: savableType,
                savable_id: savableId,
                saved: saved == null,
            }),
            {
                withCredentials: true,
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
            }
        );

        const isSaved = response.data.saved;
        console.log(`message: ${response.data.message}`);
        console.log(`saved: ${isSaved}`);

        if (isSaved) {
            e.target.setAttribute("data-saved", "on");

            document
                .getElementById(`${savableType}_${savableId}_save-indicator`)
                .setAttribute("data-fill", "on");
        } else {
            e.target.removeAttribute("data-saved");

            document
                .getElementById(`${savableType}_${savableId}_save-indicator`)
                .removeAttribute("data-fill");
        }
    });
});
