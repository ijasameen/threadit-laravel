import axios from "axios";

document.querySelectorAll(".vote-btn").forEach((button) => {
    button.addEventListener("click", async (e) => {
        const votableType = e.target.dataset.votableType;
        const votableId = e.target.dataset.votableId;
        const vote = e.target.dataset.vote;

        const response = await axios.post(
            "/votes",
            JSON.stringify({
                votable_type: votableType,
                votable_id: votableId,
                vote,
            }),
            {
                withCredentials: true,
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
            }
        );

        const upvotes = response.data.upvotes;
        const downvotes = response.data.downvotes;
        const updatedVote = response.data.vote;

        console.log(`message: ${response.data.message}`);
        console.log(`upvotes: ${upvotes}`);
        console.log(`downvotes: ${downvotes}`);
        console.log(`user_vote: ${updatedVote}`);

        if (upvotes !== null) {
            document.getElementById(
                `${votableType}_${votableId}_upvotes`
            ).textContent = upvotes;
        }

        if (downvotes !== null) {
            document.getElementById(
                `${votableType}_${votableId}_downvotes`
            ).textContent = downvotes;
        }

        if (updatedVote === "up") {
            document
                .getElementById(`${votableType}_${votableId}_upvote-indicator`)
                .setAttribute("data-fill", "on");

            document
                .getElementById(
                    `${votableType}_${votableId}_downvote-indicator`
                )
                .removeAttribute("data-fill");
        } else if (updatedVote === "down") {
            document
                .getElementById(
                    `${votableType}_${votableId}_downvote-indicator`
                )
                .setAttribute("data-fill", "on");

            document
                .getElementById(`${votableType}_${votableId}_upvote-indicator`)
                .removeAttribute("data-fill");
        } else {
            document
                .getElementById(`${votableType}_${votableId}_upvote-indicator`)
                .removeAttribute("data-fill");

            document
                .getElementById(
                    `${votableType}_${votableId}_downvote-indicator`
                )
                .removeAttribute("data-fill");
        }
    });
});
