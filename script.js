const form = document.getElementById('task-form');
const taskList = document.getElementById('task-list');
const filterStatus = document.getElementById('filter-status');
const sortOption = document.getElementById('sort-option');
const themeToggle = document.getElementById('theme-toggle');

let tasks = JSON.parse(localStorage.getItem('tasks')) || [];

function saveTasks() {
  localStorage.setItem('tasks', JSON.stringify(tasks));
}

function renderTasks() {
  let filtered = [...tasks];

  if (filterStatus.value === 'completed') {
    filtered = filtered.filter(t => t.completed);
  } else if (filterStatus.value === 'pending') {
    filtered = filtered.filter(t => !t.completed);
  }

  if (sortOption.value === 'priority') {
    const order = { high: 3, medium: 2, low: 1 };
    filtered.sort((a, b) => order[b.priority] - order[a.priority]);
  } else if (sortOption.value === 'date') {
    filtered.sort((a, b) => new Date(a.date) - new Date(b.date));
  }

  taskList.innerHTML = '';
  filtered.forEach((task, index) => {
    const row = document.createElement('tr');

    const nameCell = document.createElement('td');
    nameCell.textContent = task.text;
    if (task.completed) nameCell.style.textDecoration = 'line-through';

    const dateCell = document.createElement('td');
    dateCell.textContent = task.date || 'No date';

    const priorityCell = document.createElement('td');
    priorityCell.textContent = task.priority;
    priorityCell.className = `priority-${task.priority}`;

    const statusCell = document.createElement('td');
    statusCell.textContent = task.completed ? '✅' : '❌';

    const actionsCell = document.createElement('td');
    actionsCell.innerHTML = `
      <button onclick="toggleComplete(${index})">${task.completed ? 'Undo' : 'Done'}</button>
      <button onclick="editTask(${index})">Edit</button>
      <button onclick="deleteTask(${index})">Delete</button>
    `;

    row.append(nameCell, dateCell, priorityCell, statusCell, actionsCell);
    taskList.appendChild(row);
  });
}

function toggleComplete(index) {
  tasks[index].completed = !tasks[index].completed;
  saveTasks();
  renderTasks();
}

function editTask(index) {
  const newText = prompt('Edit task name:', tasks[index].text);
  if (newText) {
    tasks[index].text = newText.trim();
    saveTasks();
    renderTasks();
  }
}

function deleteTask(index) {
  if (confirm('Are you sure you want to delete this task?')) {
    tasks.splice(index, 1);
    saveTasks();
    renderTasks();
  }
}

form.addEventListener('submit', e => {
  e.preventDefault();
  const text = document.getElementById('task-input').value.trim();
  const date = document.getElementById('task-date').value;
  const priority = document.getElementById('task-priority').value;

  if (!text) return;

  tasks.push({ text, date, priority, completed: false });
  form.reset();
  saveTasks();
  renderTasks();
});

filterStatus.addEventListener('change', renderTasks);
sortOption.addEventListener('change', renderTasks);

themeToggle.onclick = () => {
  document.body.classList.toggle('dark');
};

renderTasks();
