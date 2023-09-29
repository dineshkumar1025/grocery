const taskInput = document.getElementById("taskInput");
const taskList = document.getElementById("taskList");

function addTask() {
    const task = taskInput.value;
    if (!task) return;

    fetch("api.php", {
        method: "POST",
        body: JSON.stringify({ task }),
        headers: {
            "Content-Type": "application/json",
        },
    })
    .then(() => {
        taskInput.value = "";
        fetchTasks();
    });
}

function deleteTask(id) {
    fetch("api.php", {
        method: "DELETE",
        body: JSON.stringify({ id }),
        headers: {
            "Content-Type": "application/json",
        },
    })
    .then(() => fetchTasks());
}

function fetchTasks() {
    fetch("api.php")
    .then((response) => response.json())
    .then((data) => {
        const tasksHTML = data.map((task) => `
            <li>
                <span>${task.task}</span>
                <button onclick="deleteTask(${task.id})">Delete</button>
            </li>
        `).join("");
        taskList.innerHTML = tasksHTML;
    });
}

// Initial fetch when the page loads
fetchTasks();
